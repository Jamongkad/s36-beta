<?php namespace Hosted\Services;

use Input, Exception, StdClass, View, Helpers;
use \Feedback\Repositories\DBFeedback;
use redisent;

class FullpageData {

    private $todays_count, $published_feed_count;

    public function __construct($company_params) {
        $this->company_params = $company_params;     
        $this->key_name = $company_params['company_name']."fullpage:metadata";
        $this->feedback = new DBFeedback;
        $this->redis = new redisent\Redis;
    }    

    public function calculate_metrics() {
        //TODO: caching candidate
        $result = new StdClass;
        $result->todays_count = $this->feedback->count_todays_feedback($this->company_params['company_id']); 
        $result->published_feed_count = $this->feedback->televised_feedback_alt($this->company_params['company_name']);
        return $result; 
    }
}
