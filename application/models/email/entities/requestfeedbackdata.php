<?php namespace Email\Entities;
use Email\Entities\Types\EmailData;
use Config;

class RequestFeedbackData extends EmailData {
    public $sendto;
    public $message;
    public $from;
    public $sites;
}
