<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View;

class Invitation extends EmailFixture {

    private $email_data;

    public function gather($email_data) {
        $this->email_data = $email_data;
    }

    public function send() {
        $email_html = View::make('email/invitation_view', Array('data' => $this->email_data))->get();     
        $this->postmark->to($this->email_data->invitee->email)
                       ->subject($this->get_subject())->html_message($email_html)->send();
    }
    
    public function get_subject() {
        return "36Stories: Admin Invitation";
    } 
}
