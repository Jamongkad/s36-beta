<?php namespace Email\Entities;
use Email\Entities\Types\EmailData;
use Config;

class ResendPasswordData extends EmailData {
    public $user_data;    
    public $host;
    public $reset_key = "jamongkad";

    public function get_host() {
        $this->host = Config::get('application.url'); 
    }

    public function reset_key() {
        crypt($this->reset_key);
    }
}
