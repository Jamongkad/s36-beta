<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Helpers, URL;

class NewFeedbackSubmission extends EmailFixture {

    public function gather($email_data) {
        $this->address = $email_data->get_addresses();
        $this->feedback_data = $email_data->get_feedback();
    }


    public function send() {
        foreach($this->address as $address) {
            $email_html = View::make('email/new_feedback_submission_view', Array(
                  'feedback_data' => $this->feedback_data
                , 'address' => $address->email
                , 'encryptstring' => $address->encryptstring
                , 'companyid' => $address->companyid
                , 'forward_url' => URL::to('feedback/modifyfeedback/'.$this->feedback_data->id)
                , 'profile_partial_view' => View::make('email/partials/profile_partial_view'
                                                       , Array('feedback_data' => $this->feedback_data))
            ))->get();     
            //print_r($email_html);
            $this->postmark->to($address->email)
                           ->subject($this->get_subject())
                           ->html_message($email_html)
                           ->send();         
        }    
    }

    public function get_subject() {
        return "36Stories |"." ".Helpers::limit_string($this->feedback_data->text);
    } 
}
