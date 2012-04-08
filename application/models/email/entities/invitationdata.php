<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;
use DBAdmin;

class InvitationData extends EmailData {

    public $account_owner;
    public $message;
    public $invitee;

    public function invitee_info_id($id) {
        $dbadmin = new DBAdmin; 
        $this->invitee = $dbadmin->fetch_admin_details_by_id($id);
    }

}
