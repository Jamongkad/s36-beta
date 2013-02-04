<?php namespace Message\Entities\Types;

abstract class Message {

    protected $message;    

    public function __construct($message) {
        $this->message = $message;
    }

    public function get_message() {
        return $this->message;
    }
}
