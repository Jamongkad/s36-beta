<?php namespace Halcyonic\Services;

use Feedback\Repositories\DBFeedback, redisent;

class HalcyonicService {
     
    private $redis, $feedback;
    public $company_id;

    public function __construct()  {
        $this->redis    = new redisent\Redis; 
        $this->feedback = new DBFeedback;
    } 
    
    //save the latest feedid to company redis
    public function save_latest_feedid() {
        $company_id = $this->company_id;
        $feed = $this->get_latest_feedid();
        if($feed) 
            $this->redis->hset("company:$company_id", "last_feedid", $feed->feedbackid);
    }

    public function get_latest_feedid() { 
        return $this->feedback->fetch_latest_feedback_id($this->company_id);
    }

    public function set_user_feedcount($user_id) { 

        $company_id = $this->company_id;

        $redis_string = "user:$user_id:$company_id";
        if(!$this->redis->hgetall($redis_string)) {
            //create data 
            $this->save_latest_feedid();
            $this->invalidate_user_data($redis_string); 
        } else {                    
            //lets check if a new feed has arrived.
            $user_last_feedid = $this->redis->hget($redis_string, "last_feedid");
            $latest_feedid = $this->redis->hget("company:$company_id", "last_feedid");

            //invalidate cache if newest feedid does not match user feedid
            if($user_last_feedid !== $latest_feedid) {
                $this->save_latest_feedid();
                $this->invalidate_user_data($redis_string);
            }                 
        }
    }

    public function invalidate_user_data($redis_string) {
        $feed = $this->get_latest_feedid();
        if($feed) { 
            $this->redis->hset($redis_string, "feedid_checked", 0);
            $this->redis->hset($redis_string, "last_feedid", $feed->feedbackid); 
        }
    }
}
