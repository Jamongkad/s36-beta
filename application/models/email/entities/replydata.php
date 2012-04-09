<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;
use DBAdmin, StdClass, DB, Config, Helpers;

class ReplyData extends EmailData {
    public $sendto;    
    public $from;
    public $bcc;
    public $message; 
    public $feedback;
}
