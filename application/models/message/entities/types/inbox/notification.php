<?php namespace Message\Entities\Types\Inbox;

use Message\Entities\Types\Message;
use Exception;

class Notification extends Message {

    protected $redis_read_key = "admin:inbox:notification:newfeedback";
    
    /*
    public function __construct($message) {
        parent::__construct($message);
    }
    */

}
