<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;
use DBAdmin, StdClass;
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
}
