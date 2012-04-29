<?php namespace Halcyonic\Services;

use redisent; 

class InboxCache {

    public $filter_array;
    private $key_string;    

    public function generate_keystring() {
        //$this->key_string = implode($this->filter_array, ":");
        $transformed_array = array_map(function($a, $b) {
            print_r($a);
            print_r($b);
        }, $this->filter_array);
        print_r($transformed_array);
    }
}
