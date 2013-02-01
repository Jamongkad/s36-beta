<?php namespace Message\Services;

use Message\Repositories\UserDirectory;
use redisent\Redis;
use Helpers;

class MessageDirector {
    
    public function __construct() {
        $this->directory = new UserDirectory;
        $this->redis     = new Redis;    
    }

    public function send_message($message) {
        $user_dir = $this->directory->fetch_users();

        Helpers::dump(get_class($message));
        
        foreach($user_dir as $user) {
            $this->redis->hset($user->user_id, "admin:inbox", $message->get_message());
        }
    }
}
