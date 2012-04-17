<?php namespace Halcyonic\Services;

use redisent;

class HalcyonicService {

    private $redis;

    public function __construct()  {
        $this->redis = new Redis; 
    }
}
