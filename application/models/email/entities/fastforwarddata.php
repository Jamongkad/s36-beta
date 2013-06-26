<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;
use DBAdmin, StdClass, DB, Config, Helpers;

class FastForwardData extends EmailData {

    public $sendto;
    public $email_comment;
    public $from; 
    public $feedback;
    public $companyid;
 
    public function make_forward_url() { 
        return Helpers::make_forward_url($this->companyid, '/feedback/modifyfeedback/'.$this->feedback->id);
    }
}
