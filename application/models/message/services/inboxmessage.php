<?php namespace Message\Services;

use redisent\Redis;
use Exception;

class InboxMessage {
    public function __construct() {
        $this->redis = new Redis; 
    }
}
