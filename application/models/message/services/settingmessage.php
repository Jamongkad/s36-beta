<?php namespace Message\Services;

use redisent;
use Input, Config, Helpers, Package;
use StdClass, Exception;

Package::load('HTMLPurifier');

class SettingMessage {
    
    private $redis;
    private $hash_key; 
    private $company;
    private $hash_nm;
    private $result;
    private $purifier;

    public function __construct($msg_type) {

        if(!$msg_type) {
            throw new Exception('Message Type is required!');
        }

        $this->redis    = new redisent\Redis;  
        $this->hash_key = "msg-".Helpers::randid();
        $this->company = Config::get('application.subdomain'); 
        $this->hash_nm  = $this->company.':settings:'.$msg_type;

        $config = \HTMLPurifier_Config::createDefault();
        $this->purifier = new \HTMLPurifier($config);
    }

    public function save($msg) { 
        return $this->redis->hsetnx($this->hash_nm, $this->hash_key, $this->purifier->purify($msg));
    }

    public function update($hash_key, $msg) { 
        return $this->redis->hset($this->hash_nm, $hash_key, $this->purifier->purify($msg));
    }

    public function get_messages() { 

        $tree = Array();

        foreach($this->redis->hkeys($this->hash_nm) as $val) {
            $leaf = new StdClass;
            $text = $this->redis->hget($this->hash_nm, $val);

            $leaf->text = $text;
            $leaf->short_text = Helpers::limit_string($text, 200);
            $leaf->id   = $val;
            $tree[] = $leaf;
        }
        $this->result = $tree;
    }

    public function delete($id) {  
        return $this->redis->hdel($this->hash_nm, $id); 
    }

    public function last_insert() { 
        $leaf = Array();
        $text = $this->redis->hget($this->hash_nm, $this->hash_key);
        $leaf['text'] = $text; 
        $leaf['short_text'] = Helpers::limit_string($text, 200);
        $leaf['id']   = $this->hash_key;
        $this->result = $leaf;
    }

    public function jsonify() {
        return json_encode($this->result);
    }
}
