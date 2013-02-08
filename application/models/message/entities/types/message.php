<?php namespace Message\Entities\Types;

abstract class Message {

    protected $message, $redis_read_key;    

    public function __construct($message, $redis_read_key) {
        $this->message = $message;
        $this->redis_read_key = $redis_read_key;
    }

    public function read_message() {
        return (object)Array('message' => $this->message, 'redis_key' => $this->redis_read_key);
    }
}
