<?php namespace Message\Entities\Types\Inbox;

use Message\Entities\Types\Message;
use Exception;

class Stub extends Message { 
    protected $redis_read_key = "inbox:"; 
}
