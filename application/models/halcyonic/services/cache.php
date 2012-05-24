<?php namespace Halcyonic\Services;

use redisent, StdClass; 

class Cache {

    public $filter_array, $key_name;
    private $key_string, $key, $company_identifier;    
    protected $redis;

    public function __construct() {
        $this->redis = new redisent\Redis; 

        if(array_key_exists('company_name', $this->filter_array)) {
            $this->company_identifier = $this->filter_array['company_name'];
        } else {
            $this->company_identifier = $this->filter_array['company_id'];
        }
    }

    public function generate_keys() {
        $this->key_string = '';
        foreach($this->filter_array as $key => $val) {
            if($val) {
                $this->key_string .= $key."=".$val.":";   
            }    
        }
        $this->key_string = substr($this->key_string, 0, -1);
        $this->key = $this->key_name.":".$this->company_identifier;
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
