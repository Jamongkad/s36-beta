<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;
use DBAdmin, StdClass, DB, Config, Helpers;

class FastForwardData extends EmailData {

    public $sendto;
    public $email_comment;
    public $from; 
    public $receiver_details;
    public $feedback;
 
    public function receiver_details() {
        if($this->sendto) { 
            $dbadmin = new DBAdmin; 
            $opts = new StdClass;
            $opts->username = $this->sendto;
            $this->receiver_details = $dbadmin->fetch_admin_details($opts);
        }
    }

    public function make_forward_url() { 
        return Helpers::make_forward_url($this->receiver_details->companyid, '/feedback/modifyfeedback/'.$this->feedback->id);
    }
}
