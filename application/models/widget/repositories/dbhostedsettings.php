<?php namespace Widget\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBHostedSettings extends S36DataObject {

    private $hosted_settings;

    public function __construct($hosted_settings) {
        parent::__construct();
        $this->hosted_settings = $hosted_settings;
    }
    
    public function save() { 
        DB::table('HostedSettings', $this->db_name)->insert($this->hosted_settings);
    } 

    public function update() {
        
    }

    public function record_exists() {
        $sql = "SELECT companyId FROM HostedSettings WHERE 1=1 AND companyId = :company_id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $this->hosted_settings['companyId'], PDO::PARAM_INT);       
        $sth->execute();

        $result = $sth->fetch(PDO::FETCH_OBJ); 
        return $result;
    }

}
