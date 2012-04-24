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

        $featured_feeds = Array();
        $published_feeds = Array();
        foreach($feeds as $feed) {           
            if($feed->isfeatured == 0 and $feed->ispublished == 1) {
                $published_feeds[] = $feed->id;
            } else {
                $featured_feeds[] = $feed->id;
            }
        }

        Helpers::dump($featured_feeds);
        //Helpers::dump($published_feeds);
        foreach($published_feeds as $published_feed) {

            $head = null;
            $node = new StdClass;
            if(isset($featured_feeds[$ctr])) {
                $head = $featured_feeds[$ctr];
            }
 
            if(($ctr % $units) == 0) { 

                $f = new ArrayIterator($published_feeds);
                $i = new LimitIterator($f, $ctr, $units);

                $coll = Array();
                foreach($i as $ky => $fr) {
                    $coll[] = $fr;      
                    $node->children = $coll;     
                }
            
                $collection[] = $node;
            }              
            $ctr += 1; 
        }
        Helpers::dump($collection);
        //return $collection;
    }
}
