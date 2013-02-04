<?php namespace Message\Entities\Types;

use Exception;

class InboxMessage extends Message {
    public function __construct($message) {
        parent::__construct($message);
    }
}
