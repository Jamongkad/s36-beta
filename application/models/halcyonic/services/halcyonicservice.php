<?php namespace Halcyonic\Services;

use S36Auth, Feedback, redisent;

class HalcyonicService {
     
    public $company_id;
    private $redis, $auth, $feedback;

    public function __construct()  {
        $this->redis = new redisent\Redis; 
        $this->feedback = new Feedback\Repositories\DBFeedback;
    } 

    public function save_latest_feedid() {
        $company_id = $this->company_id;
        $feed = $this->get_latest_feedid();
        $this->redis->hset("company:$company_id", "last_feedid", $feed->feedbackid);
    }

    public function get_latest_feedid() { 
        return $this->feedback->fetch_latest_feedback_id($this->company_id);
    }
}
