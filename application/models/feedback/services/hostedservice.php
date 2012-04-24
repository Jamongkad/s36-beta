<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Input, Exception, Helpers, DB, StdClass;

class HostedService {
    
    public function __construct() {
        $this->feedback = new DBFeedback;
    }

    public function fetch_hosted_feedback($company_id) {
        $feeds = $this->feedback->televised_feedback($company_id);
        $collection = Array();
        $groups = Array();

        $ctr = 0;
        $units = 3;
        $max = count($feeds);
        $main = new StdClass;
        $child = Array();
        foreach($feeds as $feed) {
            $end = 0;
            $ctr++;
            //echo "mod: ".(($ctr % $units) == 0)."<br/>";
            if($feed->isfeatured == 1)  {
                $main->head = $feed->id;
            } 
            if(($ctr % $units) == 0) {
                $child[] = $feed;
            }

            if($child) {
                $main->child = $child;     
            }
            
            //$collection[] = $main; 
            /*
            echo "ctr: ".$ctr++."<br/>";
            echo "end: ".$end++."<br/>";
            */

        }

        return $main;
    }
}
