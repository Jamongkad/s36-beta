<?php namespace Halcyonic\Services;

use redisent; 

class InboxCache {

    public $filter_array;
    private $key_string, $key;    

    public function generate_keystring() {
        $this->key_string = '';
        foreach($this->filter_array as $key => $val) {
            if($val) {
                $this->key_string .= $key."=".$val.":";   
            }    
        }
        $this->key_string = substr($this->key_string, 0, -1);
    }

    public function generate_key() {
        $this->key = "inbox:feeds:".$this->filter_array['company_id'];
    }

    public function get_cache() {
        return $this->redis->hget($this->key, $this->key_string);
    }
}
