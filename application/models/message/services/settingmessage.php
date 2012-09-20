<?php namespace Message\Services;

use redisent;
use Input, Config, Helpers;

class SettingMessage {

    private $redis;

    public function __construct() {
        $this->redis = new redisent\Redis; 
    }
}
