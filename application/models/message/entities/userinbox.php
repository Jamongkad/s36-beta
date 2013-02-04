<?php namespace Message\Entities;

use Exception;

class UserInbox {

    private $messages = Array();

    public function __construct($user_id) {
        $this->user_id = $user_id; 
    }
    
    /*
    public function set_message($key, $val) {
        $this->messages[] = Array('key' => $key, 'val' => $val);
    }
    */

    public function save_message() {}
}
