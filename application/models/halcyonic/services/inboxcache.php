<?php namespace Halcyonic\Services;

use redisent, StdClass; 

class InboxCache {

    public $filter_array, $key_name;
    private $key_string, $key;    
    protected $redis;

    public function __construct() {
        $this->redis = new redisent\Redis; 
    }

    public function generate_keys() {
        $this->key_string = '';
        foreach($this->filter_array as $key => $val) {
            if($val) {
                $this->key_string .= $key."=".$val.":";   
            }    
        }
        $this->key_string = substr($this->key_string, 0, -1);
        $this->key = $this->key_name.":".$this->filter_array['company_id'];
    }

    public function get_cache() {
        return $this->redis->hget($this->key, $this->key_string);
    }

    public function set_cache($data) {
        return $this->redis->hsetnx($this->key, $this->key_string, json_encode($data));
    }

    public function get_keys() {
        $result = new StdClass;     
        $result->key_string = $this->key_string;
        $result->key = $this->key;
        return $result;
    }
}
