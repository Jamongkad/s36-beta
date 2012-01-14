<?php

class Email {

    private $postmark, $feedback, $emails;  

    public function __construct($emails) { 
        $this->postmark = new PostMark("11c0c3be-3d0c-47b2-99a6-02fb1c4eed71", "news@36stories.com");
        $this->emails = $emails;
    }

    public function process_email() { 
        if ($this->emails) { 
            foreach ($this->emails as $email) {     
                /*
                if(!$this->postmark->to($email->get_address())
                                   //->bcc($email->get_bcc())
                                   ->subject($email->get_subject())
                                   ->html_message($email->get_message())
                                   ->send()) {
                   throw new Exception("Email not sent!!");
                }
                */
                $this->postmark->to($email->get_address())
                               ->subject($email->get_subject())
                               ->html_message($email->get_message())
                               ->send();
            }
        } else { 
           throw new Exception("No email object found!");
        }
    }

}
