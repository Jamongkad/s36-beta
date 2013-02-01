<?php namespace Message\Services;

use Exception;

class InboxMessage {
    public function __construct($message) {
        $this->message = $message;
    }
}
