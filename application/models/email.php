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

abstract class EmailFixture {

    private $addresses, $feedback_data, $subject;    

    public function __construct($addresses, $feedback_data, $subject) {
        $this->addresses = $addresses; 
        $this->feedback_data = $feedback_data;
        $this->subject = $subject;
    }
    
    public function get_addresses() {}
    public function get_message() {}
}

class NewFeedbackSubmission extends EmailFixture {
    
    public function __construct($addresses, $feedback_data, $subject) {
        $this->addresses = $addresses; 
        $this->feedback_data = $feedback_data;
        $this->subject = $subject;
    }

    public function get_addresses() {
        return $this->addresses;
    }

    public function get_message() {
        return View::make('email/new_feedback_submission_view', 
            Array(
                'feedback_data' => $this->feedback_data
              , 'addresses' => $this->addresses
        ));     
    }

    public function get_subject() {
        return $this->subject;     
    }
}
