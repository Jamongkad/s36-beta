<?php namespace Feedback\Services;

use \DBUser;

use \Feedback\Services\FeedbackState; 
use \Feedback\Services\FeedbackActivity;
use \Feedback\Repositories\DBFeedback;

use \Email\Entities\PublishedFeedbackData;
use \Email\Services\EmailService;


use DB, Config, Helpers;

class PublishService {

    public function __construct($feedback_id, $company_id, $user_id) { 
        $this->feedback_id = $feedback_id; 
        $this->company_id  = $company_id;
        $this->user_id     = $user_id; 
        $this->dbuser      = new DBUser;
        $this->dbfeedback    = new DBFeedback;
    }

    public function perform() {

        $status   = 'publish'; 
        //publish feedback this bitch
        $feed_obj = Array('feedid' => $this->feedback_id);
        $feedbackstate = new FeedbackState($status, Array($feed_obj), $this->company_id);

        if($state = $feedbackstate->change_state())  {  
            //Record action on activity log 
            $fba = new FeedbackActivity($this->user_id, $this->feedback_id, $status);
            
            //if no record of activity
            if($fba->check_activity_status() == False) { 
                $published_data = new PublishedFeedbackData;
                $published_data->set_publisher_email($email)
                               ->set_feedback($this->dbfeedback->pull_feedback_by_id($this->feedback_id))
                               ->set_sendtoaddresses($this->dbuser->pull_user_emails_by_company_id($this->company_id));
            
                $emailservice = new EmailService($published_data);
                $emailservice->send_email(); 
            }

            $fba->log_activity();
            //fireoff redirect somewhere here...
            /*
            $contact = DB::Table('Contact', 'master')
                          ->join('Feedback', 'Feedback.contactId', '=', 'Contact.contactId')
                          ->where('Feedback.feedbackId', '=', $this->feedback_id)
                          ->first(Array('firstName'));
            $hostname = Config::get('application.hostname');
            return View::of_home_layout()->partial('contents', 'email/thankyou_view', Array(
                'company' => DB::Table('Company', 'master')->where('companyId', '=', $this->company_id)->first(array('name'))
              , 'contact_name' => $contact->firstname
              , 'activity_check' => $activity_check
              , 'hostname' => $hostname
            ));       
            */
            return $state;
        } 
    }
}
