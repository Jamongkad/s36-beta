<?php namespace Message\Repositories;

use S36DataObject\S36DataObject;
use redisent\Redis;
use Company\Repositories\DBCompany;


class UserDirectory extends S36DataObject {

    private $redis, $dbcompany;

    public function __construct() {
        parent::__construct();
        $this->redis = new Redis;    
        $this->dbcompany = new DBCompany;
        $this->redis_key = $this->company_name.":usr:dir";
    }

    public function fetch_users() {

    }

}
