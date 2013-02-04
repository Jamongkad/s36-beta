<?php namespace Message\Entities;

use Message\Entities\Types\Message;

use Exception;

class MessageList {

    private $message_pack = Array();

    public function add_message(Message $message) {
        $this->message_pack[] = $message;
    }

    public function uncork() { 
        if(!empty($this->message_pack))
            return $this->message_pack;
    }
}
