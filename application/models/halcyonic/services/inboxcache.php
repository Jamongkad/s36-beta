<?php namespace Halcyonic\Services;

use redisent; 

class InboxCache {

    public $filter_array;
    private $key_string;    

    public function generate_keystring() {
        //$this->key_string = implode($this->filter_array, ":");
        $this->key_string = '';
        foreach($this->filter_array as $key => $val) {
            $this->key_string .= $key."=".$val.":";
        }
        substr($this->key_string, ":");
    }
}
