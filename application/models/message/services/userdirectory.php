<?php namespace Message\Services;

use redisent\Redis;
use Company\Repositories\DBCompany;

class UserDirectory {

    public function __construct() {
        $this->redis = new Redis;    
        $this->dbcompany = new DBCompany;
    }

}
