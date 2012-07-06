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
    public function _exists() {
        
    }

}
