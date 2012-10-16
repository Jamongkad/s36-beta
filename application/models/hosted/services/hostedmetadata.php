<?php namespace Hosted\Services;

use Input, Exception, StdClass, View, Helpers, Config;
use \Feedback\Repositories\DBFeedback;
use redisent;

class HostedMetadata {

    private $todays_count, $published_feed_count;

    public function __construct($company_params) {
        $this->company_params = $company_params;     
        $this->key_name = $company_params['company_name']."fullpage:metadata";
        $this->feedback = new DBFeedback;
        $this->redis = new redisent\Redis;
    }    

    public function calculate_metrics() {
        $this->todays_count = $this->feedback->count_todays_feedback($this->company_params['company_id']); 
        $this->published_feed_count = $this->feedback->televised_feedback($this->company_params['company_name']);
    }

    public function perform() {
        //TODO: caching candidate
        $result = new StdClass;
        $result->todays_count = $this->todays_count->feed_count;
        $result->published_feed_count = $this->published_feed_count->total_rows; 
        return $result; 
    }
}
