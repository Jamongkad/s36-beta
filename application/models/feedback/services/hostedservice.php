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
        $units = 4;
        $max = count($feeds);
        $main = new StdClass;
        $child = Array();
        $d = Array();
        foreach($feeds as $feed) {            
            /*
            $end = 0;
            if($feed->isfeatured == 1)  {
                $main->head = $feed->id;
            } 
            if(($ctr % $units) == 0) {
                $child[] = $feed;
            }

            if($child) {
                $main->child = $child;     
            }
            
            $collection[] = $main; 
            */
            echo "feedid: ".$feed->id." num:".$ctr." mod:".(($ctr % $units) == 0)."<br/>";        
            if(($ctr % $units) == 0) { 
                $child[] = $feed->id; 
            } else {
                $child = null;      
            } 
            
            $ctr += 1;

        }
        Helpers::dump($child);
        //return $child;
    }
}
