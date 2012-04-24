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
        $node = new StdClass;
        foreach($feeds as $feed) {            
            $end = 0;
            /*

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

            if($feed->isfeatured == 1)  {
                $node->head = $feed->id;
            }  else {
                $slice_coords = Array();
                //echo "feedid: ".$feed->id." num: ".$ctr." mod: ".(($ctr % $units) == 0)."<br/>";        
                if(($ctr % $units) == 0) { 
                    //echo "multiple: ".$ctr."<br/>";
                    $start = $ctr;   
                    $end = $ctr + $units;
                    $slice_coords['start'] = $start;
                    $slice_coords['end'] = $end;
                }             

                $node->slice = $slice_coords;
            }
            
            $ctr += 1;
            Helpers::dump($node);
        }

        //return $child;
    }
}
