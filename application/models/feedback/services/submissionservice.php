<?php namespace Feedback\Services;

use Feedback\Entities\ContactDetails, Feedback\Entities\FeedbackAttachments, Feedback\Entities\FeedbackDetails;
use Feedback\Services\FeedbackService;
use Hosted\Repositories\DBHostedSettings;

use Feedback\Repositories\DBFeedback;
use Contact\Repositories\DBContact;

use Message\Entities\Types\Inbox\Notification;
use Message\Entities\MessageList;
use Message\Services\MessageDirector;

use DBBadWords, DBDashboard, DBUser;
use redisent\Redis;
use Helpers, Input, DB;
use Email\Entities\NewFeedbackSubmissionData;
use Email\Services\EmailService;
use Config;
use SimpleArray;
use StdClass, PDOException;

class SubmissionService {

    public $debug = False;
   
    public function __construct($post_input) {
        $this->post_data        = new SimpleArray($post_input);
        $this->contact_details  = new ContactDetails($this->post_data);
        $this->feedback_details = new FeedbackDetails($this->post_data);
        $this->dbfeedback       = new DBFeedback;
        $this->dbuser           = new DBUser; 
        $this->dbcontact        = new DBContact;
        $this->hosted           = new DBHostedSettings;
        $this->dbh              = DB::connection('master')->pdo;
    }

    public function perform() {         

        if($feedback_created = $this->_create_feedback()) {

            $company_id = $this->post_data->get('company_id');
            $feedback_id = $feedback_created->feedback_id;

            $feedback = $this->dbfeedback->pull_feedback_by_id($feedback_id);

            //this creates metadata tag relationship between metadata and feedback 
            $this->_create_metadata($feedback_id);    
            $this->_send_feedbacksubmission_email(  $feedback
                                                  , $this->dbuser->pull_user_emails_by_company_id($company_id)
                                                  , $this->hosted->fetch_hosted_settings($company_id) );
            $this->_calculate_dashboard_analytics($company_id);
             
            $redis = new Redis;
            $mq    = new MessageList;
            $company_name = Config::get('application.subdomain');
            $redis->sadd("$company_name:new_feedback", $feedback_id);
            $feedbackcount = count($redis->smembers("$company_name:new_feedback"));
            $redis->hmset("$company_name:feedback_count", "count", $feedbackcount);
            $mq->add_message( new Notification("{$feedbackcount} New Feedback", "inbox:notification:newfeedback") );

            $director = new MessageDirector;
            $director->distribute_messages($mq); 

            return $feedback;

        } else {
            throw new Exception("Feedback Submission Failed!!");
        }

    }

    public function _create_feedback() {

        //let's generate data for the contacts table
        if($this->debug == True) {
            $this->contact_details->bypass_profilephoto = True;          
        }
       
        $contact_data = $this->contact_details->generate_data(); 
        
        if($new_contact_id = $this->dbcontact->insert_new_contact($contact_data)) {

            $feedback_data = $this->feedback_details->generate_data();
            $feedback_data['contactId'] = $new_contact_id; 

            $new_feedback_id = $this->dbfeedback->insert_new_feedback($feedback_data);

            $post = (object) Array(
                'feedback_text' => $feedback_data['text']
              , 'feed_id'       => $new_feedback_id
            );
            
            //we check if there is any profanity in the feedback...if so we flip the hasProfanity column to true
            $feedbackservice = new FeedbackService(new DBFeedback, new DBBadWords);
            $feedbackservice->save_feedback($post);
            
            //We determine the origin of this feedback and its from the Feedback Form
            DB::Table('FeedbackContactOrigin', 'master')->insert(Array(
                'contactId'  => $new_contact_id
              , 'feedbackId' => $new_feedback_id
              , 'origin'     => 's36'
              , 'socialId'   => $new_feedback_id
            ));

            $result_obj = new StdClass;
            $result_obj->feedback_id  = $new_feedback_id;
            $result_obj->contact_id   = $new_contact_id;

            return $result_obj;
        }

        return Null;
    }

    public function _create_metadata($feedback_id) { 
        //TODO: Move this subroutine into a seperate call to the DB.
        //this creates metadata tag relationship between metadata and feedback
        if($post_metadata = $this->post_data->get('metadata')) { 
            $this->dbh->query("SET foreign_key_checks = 0");
            foreach($post_metadata as $data) {
                //this data goes into MetadataTags Table
                $metatags_insert_id = DB::Table('MetadataTags', 'master')->insert_get_id(Array(
                    'tagName'  => $data['name']
                  , 'tagValue' => $data['value']
                  , 'tagType'  => $data['type']
                ));
                //Feedback MetadataTags junction table
                DB::Table('FeedbackMetadataTagMap', 'master')->insert(Array(
                    'feedbackId' => $feedback_id
                  , 'tagId' => $metatags_insert_id
                ));
            }
            $this->dbh->query("SET foreign_key_checks = 1");
        }   
    }

    public function _send_feedbacksubmission_email($feedback_obj, $account_obj, $hosted_obj) { 
        //upon successful feedback submission let's send an email to all parties concern
        $submission_data = new NewFeedbackSubmissionData; 
        $submission_data->set_feedback($feedback_obj)
                        ->set_sendtoaddresses($account_obj)
                        ->set_hosteddata($hosted_obj);
 

        $emailservice = new EmailService($submission_data);
        $emailservice->send_email();
    }
    
    public function _calculate_dashboard_analytics($company_id) { 
        //let's also update the summary for the dashboard analytics
        $dbdashboard = new DBDashboard($company_id);
        $dbdashboard->write_summary();
    }
    
    public function metric_response() {
        $metric = new DBMetric;
        $metric->company_id = $this->company_id; 
        $metric->increment_response();
    }
    
    
    // validate the submitted feedback data.
    public function validate_feedback_data(){
        
        // validate step 1 data.
        
        // rating should be 1-5.
        if( ! in_array($this->post_data->get('rating'), range(1, 5)) )  $this->error_msg[] = 'Rating should be 1 to 5';
        
        // title should not be blank.
        if( trim($this->post_data->get('title')) == '' )  $this->error_msg[] = 'Title should not be blank';
        
        // feedback should not be blank.
        if( trim($this->post_data->get('feedback')) == '' )  $this->error_msg[] = 'Feedback should not be blank';
        
        // recommendation should be 1 or 0.
        if( ! in_array($this->post_data->get('recommend'), range(0, 1)) )  $this->error_msg[] = 'Invalid recommendation option';
        
        
        
        // validate step 2 data.
        
        // first name should not be blank.
        if( trim($this->post_data->get('first_name')) == '' )  $this->error_msg[] = 'First name should not be blank';
        
        // last name should not be blank.
        if( trim($this->post_data->get('last_name')) == '' )  $this->error_msg[] = 'Last name should not be blank';
        
        // email should not be blank.
        if( trim($this->post_data->get('email')) == '' )  $this->error_msg[] = 'Email should not be blank';
        
        // email should be valid.
        if( ! preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $this->post_data->get('email')) )  $this->error_msg[] = 'Email should not be valid';
        
        // city should not be blank.
        if( trim($this->post_data->get('city')) == '' )  $this->error_msg[] = 'City should not be blank';
        
        // country should be somewhere from earth.
        $country = DB::table('Country')->where('code', '=', $this->post_data->get('country'))->get();
        if( empty( $country ) )  $this->error_msg[] = 'Invalid country';
        
        // permission shoulbe be 1 or 0.
        if( ! in_array($this->post_data->get('permission'), range(0, 1)) )  $this->error_msg[] = 'Invalid permission option';
        
        
        
        // validate hidden data.
        
        $company = new \Company\Repositories\DBCompany;
        $company = $company->get_company_info( Config::get('application.subdomain') );
        
        // company id should be valid.
        if( $company->companyid != $this->post_data->get('company_id') )  $this->error_msg[] = 'Invalid company id';
        
        // site id should be valid.
        if( $company->siteid != $this->post_data->get('site_id') )  $this->error_msg[] = 'Invalid site id';
        
        
        
        // return true if thre's no error, false otherwise.
        return ( empty($this->error_msg) ? true : false );
    }
}
