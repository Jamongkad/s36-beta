<?php

class EmailFactory {

    private $addresses, $message, $feedback;
    public $company_id, $feedback_id;
public function __construct(EmailData $opts) { 
        $this->publisher_email = $opts->publisher_email;
        $this->get_type = $opts->get_type();

        $this->user = new User; 
        $this->feedback = new Feedback;
    }

    private function _addresses() {        
        if($user = $this->user->pull_user_emails_by_company_id($this->company_id)) {
            return $user;  
        } else { 
            throw new Exception("No User Email addresses!");
        }
    }

    private function _feedback() { 
        if($feedback = $this->feedback->pull_feedback_by_id($this->feedback_id)) {
            return $feedback;  
        } else { 
            throw new Exception("No User Feedback!");
        }
    }

    public function execute() {

        $collection = Array();
         
        foreach($this->_addresses() as $address) {
            if($this->get_type == 'NewFeedbackSubmissionData') {
                $collection[] = new NewFeedbackSubmission($address, $this->_feedback(), "36Stories: New Feedback Notification");     
            } 

            if($this->get_type == 'PublishedFeedbackNotificationData') {
                $collection[] = new PublishedFeedbackNotification($address, $this->_feedback(), "36Stories: Published Feedback Notification", $this->publisher_email);     
            } 
        }

        return $collection;
    }
}

abstract class EmailFixture {

    private $address, $feedback_data, $subject, $user_account;    

    public function __construct($address, $feedback_data, $subject) {
        $this->address = $address; 
        $this->feedback_data = $feedback_data;
        $this->subject = $subject;
    }
    
    public function get_addresses() {}
    public function get_message() {}
}

class NewFeedbackSubmission extends EmailFixture {
    
    public function __construct($address, $feedback_data, $subject) {
        $this->address = $address; 
        $this->user_account = DB::Table('User', 'master')->where('email', '=', $address->email)->first();
        $this->feedback_data = $feedback_data;
        $this->subject = $subject;
    }

    public function get_address() {
        return $this->address->email;
    }

    public function get_message() {
        return View::make('email/new_feedback_submission_view', 
            Array(
                'feedback_data' => $this->feedback_data
              , 'address' => $this->address
              , 'user'    => $this->user_account
        ));     
    }

    public function get_subject() {
        return $this->subject;     
    }
}

class PublishedFeedbackNotification extends EmailFixture {

    public function __construct($address, $feedback_data, $subject, $publisher_email) {
        $this->address = $address; 
        $this->user_account = DB::Table('User', 'master')->where('email', '=', $address->email)->first();
        $this->feedback_data = $feedback_data;
        $this->subject = $subject;
        $this->publisher_email = DB::Table('User', 'master')->where('email', '=', $publisher_email)->first(Array('username'));
    }

    public function get_address() {
        return $this->address->email;
    }

    public function get_message() {
        return View::make('email/published_feedback_view', 
            Array(
                'feedback_data' => $this->feedback_data
              , 'address' => $this->address
              , 'user'    => $this->user_account
              , 'publisher_email' => $this->publisher_email
        ));     
    }

    public function get_subject() {
        return $this->subject;     
    }
    
}
