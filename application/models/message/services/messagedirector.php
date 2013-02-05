<?php namespace Message\Services;

use Message\Repositories\UserDirectory;
use Message\Entities\MessageList;
use Helpers;

class MessageDirector {
    
    public function __construct() {
        $this->directory = new UserDirectory;
    }

    public function distribute_messages(MessageList $messages) {
        $user_dir = $this->directory->fetch_users();
        foreach($user_dir as $user) { 
            $user->receive($messages); 
        }         
    }
}
