<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Input, Exception, Helpers, DB, StdClass;

class HostedService {
    
    public function __construct() {
        $this->feedback = new DBFeedback;
    }

    public function fetch_hosted_feedback($company_id) {
        $feeds = $this->feedback->televised_feedback($company_id);
        $collection = Array();

        $ctr = 0;
        $units = 3;
        $max = count($feeds);
        foreach($feeds as $feed) {
            $end = 1;
            if($feed->isfeatured == 1)  {
                $collection[] = $feed;
            }
            echo $ctr++."<br/>";
            echo $end++."<br/>";
        }

        return $collection;
    }
}
