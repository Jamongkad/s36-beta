<?php namespace Message\Entities\Types\Inbox;

use Exception;

class Notification extends Message {

    protected $redis_read_key = "admin:inbox:newfeedback";

    public function __construct($message) {
        parent::__construct($message);
    }
}
