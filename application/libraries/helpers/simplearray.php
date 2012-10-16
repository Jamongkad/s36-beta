<?php namespace Helpers;

use \System\Arr;

class SimpleArray { 
    public function __construct(Array $array) {
        $this->array = $array;     
    }

    public function get($key) {
        return Arr::get($this->array, $key);
    }
}

