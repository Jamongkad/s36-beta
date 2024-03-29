<?php namespace Feedback\Services;

use \DBUser;

use \Contact\Repositories\DBContact;

use \Feedback\Services\FeedbackState; 
use \Feedback\Services\FeedbackActivity;
use \Feedback\Repositories\DBFeedback;

use \Email\Entities\PublishedFeedbackData;
use \Email\Services\EmailService;

use DB, Config, Helpers, View, Exception;

class PublishService {

    private $feedback_id;
    private $company_id;
    private $user_id;
    private $dbuser;
    private $dbfeedback;

    public function __construct($feedback_id, $company_id, $user_id) { 

        if(Helpers::isnull_or_emptystring($feedback_id)) {
            throw new Exception("Feedback ID cannot be empty.");
        }

        if(Helpers::isnull_or_emptystring($company_id)) {
            throw new Exception("Company ID cannot be empty.");
        }

        if(Helpers::isnull_or_emptystring($user_id)) {
            throw new Exception("User ID cannot be empty.");
        }

        $this->feedback_id = $feedback_id; 
        $this->company_id  = $company_id;
        $this->user_id     = $user_id; 
        $this->dbuser      = new DBUser;
        $this->dbfeedback  = new DBFeedback;
    }

    public function perform() {

        $status   = 'publish'; 
        //publish feedback this bitch
        $feed_obj = Array('feedid' => $this->feedback_id);
        $feedbackstate = new FeedbackState($status, Array($feed_obj), $this->company_id);

        if($state = $feedbackstate->change_state())  {  
            $feedbackstate->write_summary();
            //Record action on activity log 
            $fba = new FeedbackActivity($this->user_id, $this->feedback_id, $status);
            
            //if no record of activity
            if($fba->check_activity_status() == False) { 
                $published_data = new PublishedFeedbackData;
                $published_data->set_publisher_email($this->dbuser->pull_user_by_id($this->user_id))
                               ->set_feedback($this->dbfeedback->pull_feedback_by_id($this->feedback_id))
                               ->set_sendtoaddresses($this->dbuser->pull_user_emails_by_company_id($this->company_id));
            
                $emailservice = new EmailService($published_data);
                $emailservice->send_email(); 
            }

            $contact = new DBContact;
            $user = $contact->get_contact_by_feedback_id($this->feedback_id);

            $fba->log_activity();

            return View::of_home_layout()->partial('contents', 'email/thankyou_view', Array(
                'company' => DB::Table('Company', 'master')->where('companyId', '=', $this->company_id)->first(array('name'))
              , 'contact_name' => $user->firstname
              , 'activity_check' => $fba->check_activity_status() 
              , 'hostname' => Config::get('application.hostname')
            ));       
        } 
    }
}
