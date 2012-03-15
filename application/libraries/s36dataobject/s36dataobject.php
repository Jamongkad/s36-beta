<?php namespace S36DataObject;

use DB, S36Auth, Exception;

abstract class S36DataObject { 

    public $dbh, $user_id, $company_id;
    public $db_name = 'master';

    public function __construct() { 
        $this->dbh = DB::connection($this->db_name)->pdo;       
        if(S36Auth::check()) {
            $this->user_id = S36Auth::user()->userid;             
            $this->company_id = S36Auth::user()->companyid;             
        } else {
            echo "36Stories Account not detected.";
            return null;
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
}
