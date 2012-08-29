<?php namespace Hosted\Services;

use Input, Exception, StdClass, View, Helpers, Config;
use Feedback\Repositories\DBFeedback;
use redisent;

class HostedMetadata {

    public function __construct($company_params) {
        $this->company_params = $company_params;     
    }    

    public function calculate_metrics() {
        $feedback = new Feedback\Repositories\DBFeedback;
        $todays_count = $feedback->count_todays_feedback($this->company_id);

        $this->redis = new redisent\Redis;
    }

    public function perform() {
        
    }
}
