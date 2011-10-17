<?php

class Email {

    private $postmark, $feedback, $emails;  

    public function __construct($emails) { 
        $this->postmark = new PostMark("11c0c3be-3d0c-47b2-99a6-02fb1c4eed71", "news@36stories.com");
        $this->emails = $emails;
    }

    public function process_email() { 
        if($this->emails) { 
            foreach($this->emails as $email) {     
                if($this->postmark->to($email->address)
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
