<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Helpers, DB;

class PublishedFeedback extends EmailFixture {
    
    public function gather($email_data) {
        $this->address = $email_data->get_addresses();
        $this->feedback_data = $email_data->get_feedback();
        $this->publisher_email = DB::Table('User', 'master')->where('email', '=', $email_data->get_publisher_email())
                                                            ->first(Array('username'));
    }

    public function send() {
        foreach($this->address as $address) {
            $email_html = View::make('email/published_feedback_view', Array(
                  'feedback_data' => $this->feedback_data
                , 'address' => $address->email
                , 'username' => ucfirst($address->username)
                , 'publisher_email' => ucfirst($this->publisher_email->username)
                , 'profile_partial_view' => View::make('email/partials/profile_partial_view'
                                                       , Array('feedback_data' => $this->feedback_data))
            ))->get();      
            //print_r($email_html);
            $this->postmark->to($address->email)->subject($this->get_subject())->html_message($email_html)->send();
        } 
    } 

    public function get_subject() {
        return "36Stories: Published Feedback Notification";
    }
}
