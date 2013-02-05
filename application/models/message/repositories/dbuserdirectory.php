<?php namespace Message\Repositories;

use S36DataObject\S36DataObject;
use redisent\Redis;
use Company\Repositories\DBCompany;
use Message\Entities\UserInbox;
use Helpers;
use StdClass;

class DBUserDirectory extends S36DataObject {

    private $redis, $dbcompany;

    public function __construct() {
        parent::__construct();
        $this->redis     = new Redis;    
        $this->dbcompany = new DBCompany;
        $this->redis_key = $this->company_name.":usr:dir";
    }
    
    public function fetch_users() {

        if( $users_dir = $this->redis->smembers($this->redis_key) ) {
            //fetch data from redis
            //echo "Fetching existing Object";
            return $this->_build_user_object($users_dir); 
        } else { 
            //build data from db and insert into redis
            if($users = $this->dbcompany->get_account_users()) { 
                foreach($users as $user) {
                    //add references to user message object
                    $user_key = $user->username.":messages";
                    $this->redis->sadd($this->redis_key, $user_key);
                }
            }
            //echo "Creating new Object"; 
            return $this->_build_user_object($this->redis->smembers($this->redis_key)); 
        }

    }

    public function delete_user($user_id = False) {
        if($users_dir = $this->redis->smembers($this->redis_key)) {
            if($user_id) { 
                $this->_delete_hash_and_smem_by($user_id);
            } else { 
                foreach($users_dir as $user) {
                    $this->_delete_hash_and_smem_by($user);
                }
            }
        } 
    }

    private function _delete_hash_and_smem_by($user_id) { 
        $this->redis->del($user_id);
        $this->redis->srem($this->redis_key, $user_id);
    }

    private function _build_user_object($members) { 
        return array_map(function($member) { return new UserInbox($member); }, $members);
    }
}
