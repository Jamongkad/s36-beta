<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;
use DBAdmin, StdClass, DB, Config;

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
        $company = DB::Table('Company', 'master')->where('companyId', '=', $this->receiver_details->companyid)->first(array('name'));
        $host_url = strtolower($company->name).'.'.Config::get('application.hostname').'.com';
        $forward_url = "http://".$host_url.'/feedback/modifyfeedback/'.$this->feedback->id;
        $login_url = trim("http://".$host_url."/login?forward_to=".$forward_url);
        return $login_url;
    }
}
