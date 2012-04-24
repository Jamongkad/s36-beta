<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Input, Exception, Helpers, DB, StdClass;

class HostedService {
    
    public function __construct() {
        $this->feedback = new DBFeedback;
    }

    public function fetch_hosted_feedback($company_id) {
        $feeds = $this->feedback->televised_feedback($company_id);
        $collection = Array();
        foreach($feeds as $feed) {
            if($feed->isfeatured == 1)  {
                $collection[] = $feed;
            }
        }

        return $collection;
    }
}
