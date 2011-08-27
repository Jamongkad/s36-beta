<?php

class Contact {

    private $dbh;
    private $user_id;
 
    public function __construct() {
        $this->dbh = DB::connection('master')->pdo;

        if(S36Auth::check())
            $this->user_id = S36Auth::user()->userid;        
    }


    public function insert_new_contact($opts) {
         $id = DB::table('Contact', 'master')->insert_get_id($opts);
         print_r($id);
    }
}
