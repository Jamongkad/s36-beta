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
          //, 'attachments_partial_view' => View::make('email/partials/attachments_partial_view', Array('feedback_data' => $this->email_data->feedback)) 
          //, 'profile_partial_view' => View::make(  'email/partials/profile_partial_view', Array('feedback_data' => $this->email_data->feedback))
        );

        Helpers::dump($this->email_data->feedback);

        $email_html = View::make('email/replyto_new_view', $data)->get();
        Helpers::dump($email_html);

        /*
        $email_html = View::make('email/replyto_view', $data)->get();
        Helpers::dump($email_html);
        */
        /*
        return $this->postmark->to($this->email_data->sendto)
                       ->bcc($this->email_data->bcc)
                       ->replyto($this->email_data->from->replyto)
                       ->subject($this->get_subject())
                       ->html_message($email_html)
                       ->send();
        */
    }

    public function get_subject() {
        return $this->subject.$this->email_data->subject;
    }
}
