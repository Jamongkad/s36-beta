<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Helpers, URL, DB, Config;

class NewFeedbackSubmission extends EmailFixture {

    public function gather($email_data) {
        $this->address = $email_data->get_addresses();
        $this->feedback_data = $email_data->get_feedback();
        $this->hosted_data = $email_data->get_hosteddata();
    }

    public function send() {

        foreach($this->address as $address) {

            $login_url = Helpers::make_forward_url($address->companyid, '/feedback/modifyfeedback/'.$this->feedback_data->id);
            $settings_url = Helpers::make_forward_url($address->companyid, '/settings');
            $email_html = View::make('email/feedback_submission_view', Array(
                  'feedback_data' => $this->feedback_data
                , 'encryptstring' => $address->encryptstring
                , 'companyid' => $address->companyid
                , 'login_url' => $login_url 
                , 'settings_url' => $settings_url 
                , 'hosted_data' => $this->hosted_data
            ))->get();
 
            Helpers::dump($email_html);
            //$this->_send_email($address->email, $this->get_subject(), $email_html);
        }    
    }

    public function get_subject() {
        return "FDBack: "." ".Helpers::limit_string(strip_tags($this->feedback_data->text));
    } 
}
