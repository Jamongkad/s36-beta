<?php namespace Message\Entities;

use Exception;

class InboxMessage {

    private $message;

    public function __construct($message) {
        $this->message = $message;
    }
}
