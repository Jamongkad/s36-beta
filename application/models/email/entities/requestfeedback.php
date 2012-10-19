<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Config;

class RequestFeedback extends EmailFixture {

    private $email_data;
    private $subject = "36Stories: Feedback Request";

    public function gather($email_data) {
        $this->email_data = $email_data; 
    }

    public function send() {
        $email_html = View::make('email/request_feedback_view', Array(
            'email_data' => $this->email_data
          , 'deploy_env' => Config::get('application.deploy_env')
          , 'subdomain'  => Config::get('application.subdomain')
        ))->get();     
        return $this->postmark->to($this->email_data->sendto->email)->subject($this->get_subject())->html_message($email_html)->send();
    }

    public function get_subject() {
        return $this->subject;
    }
}
