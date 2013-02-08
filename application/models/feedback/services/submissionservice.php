<?php namespace Feedback\Services;

use Feedback\Entities\ContactDetails, Feedback\Entities\FeedbackAttachments, Feedback\Entities\FeedbackDetails;
use Feedback\Services\FeedbackService;
use Feedback\Repositories\DBFeedback;
use Contact\Repositories\DBContact;

use Message\Entities\Types\Inbox\Notification;
use Message\Entities\MessageList;
use Message\Services\MessageDirector;

use DBBadWords, DBDashboard, DBUser;
use Helpers, Input, DB;
use Email\Entities\NewFeedbackSubmissionData;
use Email\Services\EmailService;
use SimpleArray;
use StdClass, PDOException;

class SubmissionService {

    public $debug = False;
   
    public function __construct($post_input) {
        $this->post_data        = new SimpleArray($post_input);
        $this->dbdashboard      = new DBDashboard;
        $this->contact_details  = new ContactDetails($this->post_data);
        $this->feedback_details = new FeedbackDetails($this->post_data);
        $this->dbfeedback       = new DBFeedback;
        $this->dbuser           = new DBUser; 
        $this->dbcontact        = new DBContact;
        $this->dbh = DB::connection('master')->pdo;
        //$this->feedback_attachments  = new FeedbackAttachments($this->post_data);
        //$feedback_attachments = $this->feedback_attachments->generate_data($new_feedback_id); 
    }

    public function perform() {         

        if($feedback_created = $this->_create_feedback()) {

            $company_id = $this->post_data->get('company_id');
            $feedback_id = $feedback_created->feedback_id;

            $feedback = $this->dbfeedback->pull_feedback_by_id($feedback_id);

            //this creates metadata tag relationship between metadata and feedback 
            $this->_create_metadata($feedback_id);    
            $this->_send_feedbacksubmission_email($feedback, $this->dbuser->pull_user_emails_by_company_id($company_id));
            $this->_calculate_dashboard_analytics($company_id);
            
            //this solution is a bit heavy handed try to find a much faster way to get it.
            $feedbackcount = $this->dbfeedback->newfeedback_by_company($company_id);
            $mq = new MessageList;
            $mq->add_message(new Notification("{$feedbackcount->row_count} New Feedback", "inbox:notification:newfeedback"));
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

    public function _send_feedbacksubmission_email($feedback_obj, $account_obj) { 
        //upon successful feedback submission let's send an email to all parties concern
        $submission_data = new NewFeedbackSubmissionData; 
        $submission_data->set_feedback($feedback_obj)
                        ->set_sendtoaddresses($account_obj);

        $emailservice = new EmailService($submission_data);
        $emailservice->send_email();
    }
    
    public function _calculate_dashboard_analytics($company_id) { 
        //let's also update the summary for the dashboard analytics
        $this->dbdashboard->company_id = $company_id;
        $this->dbdashboard->write_summary();
    }
    
    public function metric_response() {
        $metric = new DBMetric;
        $metric->company_id = $this->company_id; 
        $metric->increment_response();
    }
}
