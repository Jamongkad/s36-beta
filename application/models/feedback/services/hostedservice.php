<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Input, Exception, Helpers, DB, StdClass, ArrayIterator, LimitIterator;

class HostedService {

    public $units = 4;

    
    public function __construct() {
        $this->feedback = new DBFeedback;
    }

    public function fetch_hosted_feedback($company_id) {

        $feeds = $this->feedback->televised_feedback($company_id);

        $collection = Array();
        $featured_feeds = Array();
        $published_feeds = Array();
        $children_collection = Array();
    
        foreach($feeds as $feed) {           
            if($feed->isfeatured == 0 and $feed->ispublished == 1) {
                $published_feeds[] = $feed->id;
            } else {
                $featured_feeds[] = $feed->id;
            }
        }

        $ctr = 0;            
        foreach($published_feeds as $published_feed) {

            $children = Array();

            if(($ctr % $this->units) == 0) { 

                $f = new ArrayIterator($published_feeds);
                foreach(new LimitIterator($f, $ctr, $this->units) as $fr) { 
                    $children[] = $fr;     
                }

                $children_collection[] = $chilren;

            }              
            $ctr += 1;
        }
         
        foreach($children_collection as $key => $val) {

            $final_node = new StdClass; 
            if(isset($featured_feeds[$key])) {
                $final_node->head = $featured_feeds[$key];     
            }

            $final_node->children = $val;
            $collection[] = $final_node;
        }

        return $collection;
    }
}
