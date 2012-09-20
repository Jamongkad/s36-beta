<?php namespace Message\Services;

use redisent;
use Input, Config, Helpers;

class SettingMessage {
    
    private $redis;
    private $rand_key; 
    private $company;

    public function __construct() {
        $this->redis    = new redisent\Redis; 
        $this->company  = Config::get('application.subdomain');
        $this->rand_key = "msg-".Helpers::randid();
    }
}
