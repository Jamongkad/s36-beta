<?php namespace Halcyonic\Services;

use redisent, StdClass; 

class Cache {

    public $filter_array, $key_name;
    private $key_string, $key, $company_identifier;    
    protected $redis;

    public function __construct() {
        $this->redis = new redisent\Redis; 
    }

    public function generate_keys() {
        $this->company_identifier = $this->_get_company_identifier();
        $this->key_string = '';
        foreach($this->filter_array as $key => $val) {
            if($val) {
                $this->key_string .= $key."=".$val.":";   
            }    
        }
        $this->key_string = substr($this->key_string, 0, -1);
        $this->key = $this->key_name.":".$this->company_identifier;
    }

    private function _get_company_identifier() { 
        if(array_key_exists('company_name', $this->filter_array)) {
            return $this->filter_array['company_name'];
        } else {
            return $this->filter_array['company_id'];
        }
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

    public function invalidate_cache() { 
        $key = $this->key_name.":".$this->company_identifier;
        $this->redis->del($key);
    }
}
