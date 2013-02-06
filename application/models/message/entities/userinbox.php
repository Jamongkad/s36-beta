<?php namespace Message\Entities;

use Exception;
use redisent\Redis, Helpers;

class UserInbox {

    public function __construct($user_id) {
        $this->user_id = $user_id; 
        $this->redis   = new Redis;    
    }

    public function edit($key, $msg=Null) { 
        return $this->redis->hset($this->user_id, $key, $msg);         
    }

    public function read() { 
        return $this->_check_messages();
    }
     
    public function receive(MessageList $messages) {
        return $this->_save_to_redis($messages->uncork());
    }
 
    private function _save_to_redis($messages) {
        foreach($messages as $message) {
            $parts = $message->read_message();
            $this->redis->hset($this->user_id, $parts->redis_key, $parts->message);         
        } 
    }

    private function _check_messages() {
        $keys = $this->redis->hkeys($this->user_id);
        $vals = $this->redis->hvals($this->user_id);

        $messages = Array();
        for( (int)$i=0; $i<count($keys); $i++ ) {
            $messages[$keys[$i]] = $vals[$i];
        } 

        return $messages;
    }
}
