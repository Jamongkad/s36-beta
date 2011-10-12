<?php

class Email {

    private $postmark, $feedback;  

    public function __construct() { 
        $this->postmark = new PostMark("11c0c3be-3d0c-47b2-99a6-02fb1c4eed71", "news@36stories.com");
    }

    public function process_email(EmailFixture $email) { 
        if($email) {

            foreach($email->get_addresses() as $em) { 
                if($this->postmark->to($em->email)
                                  ->subject($email->get_subject())
                                  ->html_message($email->get_message())
                                  ->send()){
                    echo "Message sent";
                } else {
                   echo "Message not sent";
                }
            }

        } else {
           throw new Exception("No email object found!");
        }
    }

}

class EmailFactory {

    private $addresses, $message, $email_type;

    public function __construct($opts) {
        $this->addresses = $opts->addresses;
        $this->message   = $opts->message;
        $this->email_type = $opts->email_type;
    }

    public function execute() {

        $collection = Array();
        if($this->email_type == 'NewFeedbackSubmission') {
            foreach($this->addresses as $address) {
                $collection[] = new NewFeedbackSubmission($address, $this->message, "36Stories: New Feedback Notification");
            }
        }

        return $collection;
    }

}

abstract class EmailFixture {

    private $address, $feedback_data, $subject, $user_account;    

    public function __construct($address, $feedback_data, $subject) {
        $this->address = $addresses; 
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
        return $this->address;
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
