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
            //echo "feedid: ".$feed->id." num: ".$ctr." mod: ".(($ctr % $units) == 0)."<br/>";        
            if(($ctr % $units) == 0 and $feed->ispublished == 1) { 
                //echo "multiple: ".$ctr."<br/>";
                $f = new \ArrayIterator($feeds);
                $i = new \LimitIterator($f, $ctr, $units);
                $coll = Array();
                foreach($i as $fr) {
                    if($fr->ispublished == 1 and $fr->isfeatured == 0) {
                        $coll[] = $fr->id;      
                    }
                  
                }
                Helpers::dump($coll);
            }             
 
            $ctr += 1;
        }

        //return $child;
    }
}
