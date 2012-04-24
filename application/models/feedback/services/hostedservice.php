<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Input, Exception, Helpers, DB, StdClass, ArrayIterator, LimitIterator;

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

        $collection = Array();
        foreach($feeds as $feed) {           
            if(($ctr % $units) == 0) { 
                $node = new StdClass;
                $f = new ArrayIterator($feeds);
                $i = new LimitIterator($f, $ctr, $units);
                $coll = Array();
                foreach($i as $fr) {
                    if($fr->isfeatured == 1 and $fr->ispublished == 0) {
                        echo $fr->id."<br/>";     
                        $node->head = $fr->id;
                    } 

                    $coll[] = $fr->id;      
                    $node->children = $coll;     

                }
 
                $collection[] = $node;
            }              
            $ctr += 1;
        }

        return $collection;
    }
}
