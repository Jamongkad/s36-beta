<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Config, Helpers;

//Email Test Slug fo y'all motha bitchez
class Slug extends EmailFixture {  

    private $email_data;
    private $subject = "36Stories: Email Testing Slug ";

    public function gather($email_data) {
        $this->email_data = $email_data; 
    }

    public function send() {
        return $this->postmark
                    ->to($this->email_data->sendto)
                    ->bcc($this->email_data->bcc)
                    ->replyto($this->email_data->from->replyto)
                    ->subject($this->get_subject())
                    ->html_message("<h1>This is a test. Disregard.</h1>")
                    ->send(); 
    }

    public function get_subject() {
        return $this->subject;
    }
}
