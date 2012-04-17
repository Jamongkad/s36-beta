<?php namespace Halcyonic\Services;

use S36Auth;

class HalcyonicService {

    private $redis, $auth, $feedback;

    public function __construct()  {
        $this->redis = new \redisent\Redis; 
        $this->feedback = new \Feedback\Repositories\DBFeedback;
        $this->auth = S36Auth::user();
    } 
}
