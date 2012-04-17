<?php namespace Halcyonic\Services;

use S36Auth, Feedback;

class HalcyonicService {
     
    public $company_id;
    private $redis, $auth, $feedback;

    public function __construct()  {
        $this->redis = new \redisent\Redis; 
        $this->feedback = new Feedback\Repositories\DBFeedback;
    } 

    public function save_latest_feedid() {
        $company_id = $this->company_id;
        $feed = $this->feedback->fetch_latest_feedback_id($this->company_id);
        $this->redis->hset("company:$company_id", "last_feedid", $feed->feedbackid);
    }
}
