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

            //oh shit...
            //$company = DB::Table('Company', 'master')->where('companyId', '=', $address->companyid)->first(array('name'));
            //print_r($company);
            $host_url = Config::get('application.url');
            $forward_url = $host_url.'/feedback/modifyfeedback/'.$this->feedback_data->id;
            $login_url = trim($host_url."/login?forward_to=".$forward_url);

            $email_html = View::make('email/new_feedback_submission_view', Array(
                  'feedback_data' => $this->feedback_data
                , 'address' => $address->email
                , 'encryptstring' => $address->encryptstring
                , 'companyid' => $address->companyid
                , 'login_url' => $login_url
                , 'profile_partial_view' => View::make('email/partials/profile_partial_view'
                                                       , Array('feedback_data' => $this->feedback_data))
            ))->get();     
            print_r($email_html);
            /*
            $this->postmark->to($address->email)
                           ->subject($this->get_subject())
                           ->html_message($email_html)
                           ->send();         
            */
        }    
    }

    public function get_subject() {
        return "36Stories |"." ".Helpers::limit_string($this->feedback_data->text);
    } 
}
