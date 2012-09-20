<?php namespace Message\Services;

use redisent;
use Input, Config, Helpers;

class SettingMessage {
    
    private $redis;
    private $rand_key; 
    private $company;

    public function __construct($msg_type) {
        $this->redis    = new redisent\Redis; 
        $this->company  = Config::get('application.subdomain');
        $this->rand_key = "msg-".Helpers::randid();
        $this->msg_type = $msg_type;
    }

    public function get_messages() {
        return true; 
    }
}
