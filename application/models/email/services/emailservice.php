<?php namespace Email\Services;

use PostMark;
use Email\Services;
use Email\Entities\Types\EmailData;

class EmailService { 
    
    public function __construct(EmailData $opts) {
        $this->factory = new EmailFactory($opts);
    }

    public function execute() {
        return $this->factory->assemble();
    }
}
