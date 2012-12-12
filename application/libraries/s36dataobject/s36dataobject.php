<?php namespace S36DataObject;

use DB, S36Auth, Config;
use Exception;

abstract class S36DataObject { 

    public $dbh, $user_id, $company_id, $company_name;
    public $db_name = 'master';

    public function __construct() { 
        $this->dbh = DB::connection($this->db_name)->pdo;       
        $this->company_name = Config::get('application.subdomain');
        //TODO: Take note if no login cookie you cannot test inbox specific data retrieval
        if(S36Auth::check()) {
            $this->user_id = S36Auth::user()->userid;             
            $this->company_id = S36Auth::user()->companyid;             
        } 
    }

    public function escape($string) {
        $return = '';

        for($i = 0; $i < strlen($string); ++$i) {
            $char = $string[$i];
            $ord = ord($char);
            if($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126) {
                $return .= $char;     
            }
           
            else {
                $return .= '\\x' . dechex($ord);     
            }
           
        }
        return $return;                                                                                       
    }

    public function quote($string) {
        return $this->dbh->quote($string);
    }

    public function show_process_list() {
        return $this->dbh->query('SHOW FULL PROCESSLIST');
    }
}
