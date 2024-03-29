<?php namespace Message\Repositories;

use redisent;
use Input, Config, Helpers, Package;
use StdClass, Exception;

Package::load('HTMLPurifier');

class RDMessage { 

    private $redis;
    private $hash_key; 
    private $company;
    private $hash_nm;
    private $result;
    private $purifier;
    private $text_limit = 3;

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

    public function get($hash_key) {
        $this->result = $this->_get_leaf($this->hash_nm, $hash_key);
    }

    public function get_messages() { 
        $tree = Array();
        foreach($this->redis->hkeys($this->hash_nm) as $val) {
            $leaf = new StdClass;
            $text = ucfirst(strtolower($this->redis->hget($this->hash_nm, $val)));

            $leaf->text = $text;
            $leaf->short_text = Helpers::limit_text($text, $this->text_limit);
            $leaf->id   = $val;
            $tree[] = $leaf;
        }
        $this->result = $tree;
    }

    public function save($msg) { 
        return $this->redis->hsetnx($this->hash_nm, $this->hash_key, $this->purifier->purify($msg));
    }

    public function delete($msgid) { 
        return $this->redis->hdel($this->hash_nm, $msgid); 
    }

    public function update($msgid, $msg) { 
        return $this->redis->hset($this->hash_nm, $msgid, $this->purifier->purify($msg));
    }

    public function last_insert() {
        $this->result = $this->_get_leaf($this->hash_nm, $this->hash_key); 
    }

    public function _get_leaf($hash, $hash_key) {

        $leaf = Array();
        $text = ucfirst(strtolower($this->redis->hget($hash, $hash_key)));

        $leaf['text'] = $text; 
        $leaf['short_text'] = Helpers::limit_text($text, $this->text_limit);
        $leaf['id']   = $hash_key;

        return $leaf; 
    }

    public function jsonify() { 
        return json_encode($this->result);
    }
}
