<?php namespace Halcyonic\Services;

use redisent; 

class InboxCache {

    private $key_string;    
    private $filter_array;

    public function set_inbox_filter(Array $filters) {
        $this->filter_array = $filters; 
    }

    public function generate_keystring() {
        $this->key_string = implode($this->filter_array, ":");
    }
}
