<?php
//TODO: Refactor
class EmailFactory {

    private $opts;

    public $addresses, $message, $feedback;

    public function __construct(EmailData $opts) { 
        $this->opts = $opts;
        $this->publisher_email = $opts->publisher_email;
        $this->get_type = $opts->get_type();
    }
    
    public function execute() {

        $collection = Array();
         
        foreach($this->addresses as $address) {
            if($this->get_type == 'NewFeedbackSubmissionData') {
                $collection[] = new NewFeedbackSubmission($address, $this->feedback, "36Stories: New Feedback Notification");     
            } 

            if($this->get_type == 'PublishedFeedbackNotificationData') {
                $collection[] = new PublishedFeedbackNotification($address, $this->feedback, "36Stories: Published Feedback Notification", $this->publisher_email);     
            } 

            if($this->get_type == 'RequestFeedbackData') {
                $collection[] = new RequestFeedback($address, $this->message, "36Stories: Feedback Request", $this->opts);
            }

            if($this->get_type == 'InvitationNotificationData') {
                $collection[] = new Invitation($address, $this->message, "36Stories: Admin Invitation");
            }

            if($this->get_type == 'FastForwardData') {
                $collection[] = new FastForward($address, $this->message,  "36Stories: Fast Forward");
            }
        }

        return $collection;
    }
}

abstract class EmailFixture {

    private $address, $feedback_data, $subject, $user_account, $bcc;    

    public function __construct($address, $feedback_data, $subject) {
        $this->address = $address; 
        $this->feedback_data = $feedback_data;
        $this->subject = $subject;
    }
    
    public function get_addresses() {}
    public function get_message() {}
    public function get_bcc() {}
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

class RequestFeedback extends EmailFixture {
    
    public function __construct($address, $message, $subject, $email_data) {
        $this->email_data = $email_data;
        $this->address = $address; 
        $this->message = $message;
        $this->subject = $subject;
    }

    public function get_address() {
        return $this->address->email;
    }

    public function get_message() {
        return View::make('email/request_feedback_view', Array(
            'email_data' => $this->email_data
          , 'address' => $this->address
          , 'message' => $this->message
          , 'deploy_env' => config::get('application.deploy_env')
        ));     
    }

    public function get_subject() {
        return $this->subject;     
    }
}

class Invitation extends EmailFixture {

    public function __construct($address, $message, $subject) {
        $this->address = $address; 
        $this->message = $message;
        $this->subject = $subject;
    }
        
    public function get_address() {
        return $this->address->email;
    }

    public function get_message() {
        return View::make('email/invitation_view', Array(
            'address' => $this->address
          , 'message' => $this->message
          , 'user' => $this->get_address()
        ));     
    }

    public function get_subject() {
        return $this->subject;     
    }
}

class FastForward extends EmailFixture {
    
    public function __construct($address, $message, $subject) {
        $this->address = $address; 
        $this->message = $message;
        $this->subject = $subject;
    }

    public function get_message() { 
        return View::make('email/fastforward_view', Array(
            'message' => $this->message
          , 'user' => $this->get_address()
          , 'sender' => $this->message->user
          , 'feedback_data' => $this->message->feedback
        ));     
    }

    public function get_address() { 
        return $this->address->email;
    }

    public function get_bcc() {
        return $this->message->bcc;     
    }
     
    public function get_subject() {
        return $this->subject;     
    }
}
