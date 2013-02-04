<?php namespace Message\Entities;

use Exception;

class MessageList {

    private $message_pack = Array();

    public function add_message($message) {
        $this->message_pack[] = $message;
    }
}
