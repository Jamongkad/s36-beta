<?php namespace Message\Repositories;

use S36DataObject\S36DataObject;
use redisent\Redis;
use Company\Repositories\DBCompany;


class UserDirectory extends S36DataObject {

    private $redis, $dbcompany;

    public function __construct() {
        parent::__construct();
        $this->redis     = new Redis;    
        $this->dbcompany = new DBCompany;
        $this->redis_key = $this->company_name.":usr:dir";
    }
    
    public function fetch_users() {
        if($this->redis->exists($this->redis_key)) {
            //fetch data from redis
            return $this->redis->smembers($this->redis_key);
        } else { 
            //build data from db and insert into redis
            $users = $this->dbcompany->get_account_users();
            foreach($users as $user) {
                $user_key = $user->username.":messages";
                $this->redis->sadd($this->redis_key, $user_key);
                $this->redis->hset($user_key, "admin:inbox", Null);
            }

            return $this->redis->smembers($this->redis_key);
        }
    }

}
