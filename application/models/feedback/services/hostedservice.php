<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Input, Exception, Helpers, DB, StdClass, ArrayIterator, LimitIterator;
use redisent;

class HostedService {

    public $units = 4;

    
    public function __construct() {
        $this->feedback = new DBFeedback;
        $this->redis = new redisent\Redis; 
    }

    public function fetch_hosted_feedback($company_id, $ignore=False) {
   
        if($ignore or !$collection = $this->redis->lrange("hosted:feeds:$company_id", 0, -1)) {
 
            $feeds = $this->feedback->televised_feedback($company_id);

            $collection = Array();
            $featured_feeds = Array();
            $published_feeds = Array();
            $children_collection = Array();
        
            foreach($feeds as $feed) {           
                if($feed->isfeatured == 0 and $feed->ispublished == 1) {
                    $published_feeds[] = $feed;
                } else {
                    $featured_feeds[] = $feed;
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

                    $children_collection[] = $children;

                }              
                $ctr += 1;

            }
             
            foreach($children_collection as $key => $val) {
                $final_node = new StdClass; 
                if(isset($featured_feeds[$key])) {
                    $final_node->head = $featured_feeds[$key];     
                }

                $final_node->children = $val;
                $this->redis->rpush("hosted:feeds:$company_id", json_encode($final_node));
                $collection[] = $final_node;
            }     
            echo "Fresh Load";
            return $collection;
        } else {
            echo "From Cache";
            return array_map(function($arr) {
                return json_decode($arr);
            }, $collection);
        }
    }
}
