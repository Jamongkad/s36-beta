<?php namespace Email\Entities;
use Email\Entities\Types\EmailData;
use Config;

class ResendPasswordData extends EmailData {
    public $user;    
    public $host = Config::get('application.host');
}
