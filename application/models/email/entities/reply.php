<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Config, Helpers;

class Reply extends EmailFixture {
    
    private $email_data;
    private $subject = "FDBack: We received your feedback ";

    public function gather($email_data) {
        $this->email_data = $email_data; 
    }
 
    public function send() {

        $data = Array(
            'message' => $this->email_data->message
          , 'sender' => ucfirst($this->email_data->from->username)
          , 'submission_date' => $this->email_data->feedback->date
          , 'emailto' => $this->email_data->sendto
          , 'email_data' => $this->email_data->feedback
        );

        $email_html = View::make('email/replyto_view', $data)->get();
        return $this->postmark->to($this->email_data->sendto)
                       ->bcc($this->email_data->bcc)
                       ->replyto($this->email_data->from->replyto)
                       ->subject($this->get_subject())
                       ->html_message($email_html)
                       ->send();
    }

    public function get_subject() {
        return $this->subject.$this->email_data->subject;
    }
}
