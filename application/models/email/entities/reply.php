<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Config;

class Reply extends EmailFixture {
    
    private $email_data;
    private $subject;

    public function gather($email_data) {
        $this->email_data = $email_data; 
    }
 
    public function send() {
         
        $email_html = View::make('email/replyto_view', Array(
            'message' => $data['message']
          , 'sender' => ucfirst($data['username'])
          , 'submission_date' => $feedback_data->date
          , 'emailto' => $data['emailto']
          , 'profile_partial_view' => View::make('email/partials/profile_partial_view', Array('feedback_data' => $feedback_data))
        ));
        /*
        reference
        $this->postmark->to($this->email_data->sendto->email)->subject($this->get_subject())->html_message($email_html)->send();
        $this->postmark->to($data['emailto'])
                 ->replyto($data['replyto'])
                 ->bcc($bcc)
                 ->subject("36Stories | ".$data['subject'])
                 ->html_message($message)
                 ->send();
        */
    }

    public function get_subject() {
        return "36Stories: ".$this->email_data->subject;
    }
}
