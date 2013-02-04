<?php namespace Message\Entities;

use Exception;
use redisent\Redis, Helpers;

class UserInbox {

    private $messages = Array();

    public function __construct($user_id) {
        $this->user_id = $user_id; 
        $this->redis   = new Redis;    
        $this->_synchronize_inbox();
    }
     
    /* return void */
    public function save_message() {
        
    }

    /* return void */
    public function _synchronize_inbox() {
        /* fields to be initialized in admin hash for messaging */
        $this->redis->hset($this->user_id, "admin:inbox:notification", Null);
        $this->redis->hset($this->user_id, "admin:inbox:private", Null);
        $this->_check_messages();
    }

    /* return void */
    public function _check_messages() {
        $keys = $this->redis->hkeys($this->user_id);
        $vals = $this->redis->hvals($this->user_id);

        $d = $this->redis->hgetall($this->user_id);

        Helpers::dump($d);

        for( (int)$i=0; $i<count($keys); $i++ ) {
            $this->messages[] = Array('key' => $keys[$i], 'val' => $vals[$i]);           
        } 
    }
}
