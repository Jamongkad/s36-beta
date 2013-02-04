<?php namespace Message\Services;

use Message\Repositories\UserDirectory;
use Message\Entities\MessageList;
use redisent\Redis;
use Helpers;

class MessageDirector {
    
    public function __construct() {
        $this->directory = new UserDirectory;
        $this->redis     = new Redis;    
    }

    public function distribute_messages(MessageList $messages) {
        $user_dir = $this->directory->fetch_users();
        foreach($user_dir as $user) { 
            $user->receive($messages); 
        }
         
        /*
        foreach($user_dir as $user) {
            if($message instanceof InboxMessage) {
                $this->redis->hset($user->user_id, "admin:inbox", $message->get_message());               
            }
        }
        */
    }
}
