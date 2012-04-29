<?php namespace Halcyonic\Services;

use redisent; 

class InboxCache {

    public $filter_array;
    private $key_string;    

    public function generate_keystring() {
        $this->key_string = '';
        foreach($this->filter_array as $key => $val) {
            if($val) {
                $this->key_string .= $key."=".$val.":";   
            }    
        }
        $this->key_string = substr($this->key_string, 0, -1);
    }
}
