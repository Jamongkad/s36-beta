<?php namespace Halcyonic\Services;

use S36Auth;

class HalcyonicService {

    private $redis, $auth;

    public function __construct()  {
        $this->redis = new \redisent\Redis; 
        $this->auth = S36Auth::user();
    } 
}
