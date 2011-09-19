<?php namespace S36DataObject;

use DB;
use S36Auth; 

abstract class S36DataObject { 

    private $dbh;
    private $user_id;

    public function __construct() { 
        $this->dbh = DB::connection('master')->pdo;

        if(S36Auth::check())
            $this->user_id = S36Auth::user()->userid;        
    }
}
