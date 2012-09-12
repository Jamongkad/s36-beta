<?php namespace Feedback\Services;

use \DBUser;
use \Feedback\Services\FeedbackState; 
use \Feedback\Services\FeedbackActivity;
use \Email\Entities\PublishedFeedbackData;
use \Email\Services\EmailService;

use DB, Config, Helpers;

class PublishService {
    public function perform() {
        if($key != null) {  
            $user = new DBUser; 
            $status = 'publish'; 
            //publish feedback this bitch
            $feed_obj = Array('feedid' => $feedback_id);
            $feedbackstate = new Feedback\Services\FeedbackState($status, Array($feed_obj), $company_id);
            $publish_success = $feedbackstate->change_state();

            if($publish_success)  { 
                //since we're already logged in...we just need one property here...the publisher's email
                $publisher = Array('name' => $username, 'company_id' => $company_id, 'email' => $email);
                
                //Record action on activity log
                //$fba = new Feedback\Services\FeedbackActivity($publisher->userid, $feedback_id, $status);
                $fba = new Feedback\Services\FeedbackActivity($publisher, $feedback_id, $status);
                $activity_check = $fba->log_activity();
                
                //if no record of activity
                if(!is_object($activity_check)) { 
                    $published_data = new Email\Entities\PublishedFeedbackData;
                    $published_data->set_publisher_email($email)
                                   ->set_feedback($feedback->pull_feedback_by_id($feedback_id))
                                   ->set_sendtoaddresses($user->pull_user_emails_by_company_id($company_id));
                
                    $emailservice = new Email\Services\EmailService($published_data);
                    $emailservice->send_email(); 
                }

                $contact = DB::Table('Contact', 'master')
                              ->join('Feedback', 'Feedback.contactId', '=', 'Contact.contactId')
                              ->where('Feedback.feedbackId', '=', $feedback_id)
                              ->first(Array('firstName'));

                $hostname = Config::get('application.hostname');

                //fireoff redirect somewhere here...
                return View::of_home_layout()->partial('contents', 'email/thankyou_view', Array(
                    'company' => DB::Table('Company', 'master')->where('companyId', '=', $company_id)->first(array('name'))
                  , 'contact_name' => $contact->firstname
                  , 'activity_check' => $activity_check
                  , 'hostname' => $hostname
                ));       
            } else {
                throw new Exception("Feedback $feedback_id was not published!");
            }
        } else {
            print_r("Something went wrong");
        }    
        
    }
}
