<?php namespace Message\Services;

use redisent;
use Input, Config, Helpers;
use StdClass;

class SettingMessage {
    
    private $redis;
    private $hash_key; 
    private $company;
    private $hash_nm;
    private $result;

    public function __construct($msg_type) {
        $this->redis    = new redisent\Redis;  
        $this->hash_key = "msg-".Helpers::randid();
        $this->company = Config::get('application.subdomain'); 
        $this->hash_nm  = $this->company.':settings:'.$msg_type;
    }

    public function save_message($msg) { 
        return $this->redis->hsetnx($this->hash_nm, $this->hash_key, $msg);
    }

    public function get_messages() { 

        $tree = Array();

        foreach($this->redis->hkeys($this->hash_nm) as $val) {
            $leaf = new StdClass;
            $leaf->text = $this->redis->hget($this->hash_nm, $val);
            $leaf->id   = $val;
            $tree[] = $leaf;
        }
        //return json_encode($collection);
        $this->result = $tree;
    }

    public function last_insert() { 
        $leaf = Array();
        $leaf['text'] = $this->redis->hget($this->hash_nm, $this->hash_key);
        $leaf['id']   = $this->hash_key;
        //return json_encode($final_data);
        return $this;
    }

    public function jsonify() {
        return json_encode($this->result);
    }
}
