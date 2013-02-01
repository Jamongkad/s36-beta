<?php namespace Message\Entities;

use Exception;

class InboxMessage {
    public function __construct($message) {
        $this->message = $message;
    }
}
