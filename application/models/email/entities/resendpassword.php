<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Config;

class ResendPassword extends EmailFixture {    
    private $email_data;
    private $subject = "36Stories: Reset your 36Stories password";

    public function gather($email_data) {
        $this->email_data = $email_data; 
    }

    public function send() {
        $email_html = $this->email_html();
        $this->postmark->to($this->email_data->user_data->email)->subject($this->get_subject())->html_message($email_html)->send();
    }

    public function email_html() { 
        $email_html = View::make('email/resendpassword_view', Array(
            'email_data' => $this->email_data
        ))->get();     
        
        return $email_html;
    }

    public function get_subject() {
        return $this->subject;
    }
}
