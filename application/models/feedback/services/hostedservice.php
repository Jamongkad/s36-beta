<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Input, Exception, Helpers, DB, StdClass, ArrayIterator, LimitIterator;

class HostedService {

    public $units = 4;
    private $ctr = 0;
    
    public function __construct() {
        $this->feedback = new DBFeedback;
    }

    public function fetch_hosted_feedback($company_id) {

        $feeds = $this->feedback->televised_feedback($company_id);

        $collection = Array();
        $featured_feeds = Array();
        $published_feeds = Array();
        $children_collection = Array();
        
        /*
        foreach($feeds as $feed) {           
            if($feed->isfeatured == 0 and $feed->ispublished == 1) {
                $published_feeds[] = $feed;
            } else {
                $featured_feeds[] = $feed;
            }
        }
        */

        $published_feeds = array_map(function($obj) {
            if($obj['isfeatured'] == 0 and $obj['ispublished'] == 1) {
                return $obj; 
            }
        }, $feeds);

        $featured_feeds = array_map(function($obj) {
            if($obj['isfeatured'] == 1 and $obj['ispublished'] == 0) {
                return $obj; 
            }  
        }, $feeds);
         
        foreach($published_feeds as $published_feed) {

            $node = new StdClass;
            $node->children = Array();

            if(($this->ctr % $this->units) == 0) { 

                $f = new ArrayIterator($published_feeds);
                foreach(new LimitIterator($f, $this->ctr, $this->units) as $fr) { 
                    $node->children[] = $fr;     
                }
                $children_collection[] = $node;

            }              
            $this->ctr += 1;
        }
         
        foreach($children_collection as $key => $val) {

            $final_node = new StdClass; 
            if(isset($featured_feeds[$key])) {
                $final_node->head = $featured_feeds[$key];     
            }

            $final_node->children = $val->children;
           
            $collection[] = $final_node;
        }
        return $collection;
    }
}
