<?php namespace S36DataObject;

use DB, S36Auth, Config;
use Exception, PDO;

abstract class S36DataObject { 

    public $dbh, $user_id, $company_id, $company_name, $email, $username;
    public $db_name = 'master';

    public function __construct() { 
        $this->dbh = DB::connection($this->db_name)->pdo;       
        $this->company_name = $this->_is_valid_company(Config::get('application.subdomain'));
        //TODO: Take note if no login cookie you cannot test inbox specific data retrieval
        if(S36Auth::check()) {
            $this->user_id = S36Auth::user()->userid;             
            $this->company_id = S36Auth::user()->companyid;             
            $this->username = S36Auth::user()->username;             
            $this->email = S36Auth::user()->email;             
        } 
    }

    private function _is_valid_company($company_name) {
        $sql = "SELECT Company.name FROM Company WHERE Company.name = :company_name LIMIT 1";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(":company_name", $company_name); 
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_OBJ);
        if(!$result) {
            throw new Exception("Company ".$this->company_name." does not exists!");     
        }        

        return $result->name;
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
