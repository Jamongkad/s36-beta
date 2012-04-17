<?php namespace Halcyonic\Services;

class HalcyonicService {

    private $redis;

    public function __construct()  {
        $this->redis = new \redisent\Redis; 
    }
}
