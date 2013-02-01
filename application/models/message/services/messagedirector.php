<?php namespace Message\Services;

use Message\Repositories\UserDirectory;
use Helpers;

class MessageDirector {
    
    public function __construct() {
        $this->directory = new UserDirectory;
    }

    public function use_message($message) {
        $user_dir = $this->directory->fetch_users();
        Helpers::dump($user_dir);
    }
}
