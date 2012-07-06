<?php namespace Widget\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;

class DBHostedSettings extends S36DataObject {

    public function __construct($hosted_settings) {
        //parent::__construct();
        $this->hosted_settings = $hosted_settings;
    }
    
    public function save() { 
        DB::table('HostedSettings', 'master')->insert($this->feedback_data);
    } 
    public function update() {
        
    }
    public function _exists() {
        
    }

}
