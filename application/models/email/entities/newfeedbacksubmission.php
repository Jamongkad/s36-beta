<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Helpers, URL, DB, Config;

class NewFeedbackSubmission extends EmailFixture {

    public function gather($email_data) {
        $this->address = $email_data->get_addresses();
        $this->feedback_data = $email_data->get_feedback();
    }

    public function send() {
        foreach($this->address as $address) {

            $login_url = Helpers::make_forward_url($address->companyid, '/feedback/modifyfeedback/'.$this->feedback_data->id);
            $email_html = View::make('email/new_feedback_submission_view', Array(
                  'feedback_data' => $this->feedback_data
                , 'address' => $address->email
                , 'encryptstring' => $address->encryptstring
                , 'companyid' => $address->companyid
                , 'login_url' => $login_url
                , 'profile_partial_view' => View::make('email/partials/profile_partial_view'
                                                       , Array('feedback_data' => $this->feedback_data))
            ))->get();     

            //Helpers::dump($email_html); 
            $this->postmark->to($address->email)
                           ->subject($this->get_subject())
                           ->html_message($email_html)
                           ->send();          
        }    
    }

    public function get_subject() {
        return "36Stories: "." ".Helpers::limit_string(strip_tags($this->feedback_data->text));
    } 
}
