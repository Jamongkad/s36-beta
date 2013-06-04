<?php namespace Email\Entities;

use Email\Entities\Types\EmailFixture;
use View, Helpers, URL, DB, Config;

class Autopublish extends EmailFixture {

    private $address, $feedback_data;
    
    public function gather($email_data) {
        $this->address = $email_data->get_addresses();
        $this->feedback_data = $email_data->get_feedback();
    }

    public function send() {
      
        $email_html = View::make('email/replyto_view');

        Helpers::dump($email_html);
    }
}
