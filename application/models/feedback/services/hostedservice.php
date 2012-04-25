<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Input, Exception, Helpers, DB, StdClass, ArrayIterator, LimitIterator;

class HostedService {
    
    public function __construct() {
        $this->feedback = new DBFeedback;
    }

    public function fetch_hosted_feedback($company_id) {

        $feeds = $this->feedback->televised_feedback($company_id);

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

        foreach($published_feeds as $published_feed) {

            $node = new StdClass;
            if(isset($featured_feeds[$ctr])) {
                echo $featured_feeds[$ctr];
            }
            $node->head = $ctr;
            $node->children = Array();

            $fb_node = new FeedbackNode($ctr);

            if(($ctr % $units) == 0) { 

                $f = new ArrayIterator($published_feeds);
                foreach(new LimitIterator($f, $ctr, $units) as $fr) { 
                    $node->children[] = $fr;     
                }

                $collection[] = $fb_node;//$node;

            }             
       
            $ctr += 1;
        }
        Helpers::dump($collection);
        //return $collection;
    }
}

class FeedbackNode {

    private $id;
    private $children = Array();

    public function __construct($id) {
        $this->id = $id;      
    }

    public function add_child($child) {
        $this->children[] = $child;
    }
}
