<?php namespace Message\Entities;

use Exception;
use redisent\Redis, Helpers;

class UserInbox {

    private $message = Array();

    public function __construct($user_id) {
        $this->user_id = $user_id; 
        $this->redis   = new Redis;    
        $this->_fetch_messages();
    }

    public function edit($key, $msg=Null) { 
        return $this->redis->hset($this->user_id, $key, $msg);         
    }

    public function read_all($key=False) { 
        if($this->messages)
            return $this->messages;
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

    private function _fetch_messages() {
        $keys = $this->redis->hkeys($this->user_id);
        $vals = $this->redis->hvals($this->user_id);

        for( (int)$i=0; $i<count($keys); $i++ ) {
            $this->messages[$keys[$i]] = $vals[$i];
        } 

        return $this->messages;
    }
}
