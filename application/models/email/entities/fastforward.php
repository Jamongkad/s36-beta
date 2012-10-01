<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View;

class FastForward extends EmailFixture {

    private $email_data;
    private $subject = "36Stories: Fast Forward";

	public function gather($email_data){
        $this->email_data = $email_data; 
	}

    public function send() {

        $email_html = View::make('email/fastforward_view', Array(
            'message' => $this->email_data->email_comment
          , 'receiver' => $this->email_data->receiver_details
          , 'sender' => $this->email_data->from
          , 'feedback_data' => $this->email_data->feedback
          , 'login_url' => $this->email_data->make_forward_url()
        ))->get();     

        $this->postmark->to($this->email_data->sendto)
                       ->subject($this->get_subject())->html_message($email_html)->send();
    }
    
    public function get_subject() {
        return $this->subject; 
    }

}
