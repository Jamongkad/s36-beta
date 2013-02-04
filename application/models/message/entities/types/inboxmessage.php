<?php namespace Message\Entities\Types;

use Exception;

class InboxMessage extends Message {

    private $redis_read_key = "admin:inbox:notification";

    public function __construct($message) {
        parent::__construct($message);
    }
}
