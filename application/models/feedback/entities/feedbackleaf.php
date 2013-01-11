<?php namespace Feedback\Entities;

//Leaf used by HostedService to build feedback tree

class FeedbackLeaf {
    public function __construct($feed) {
        if($feed->isfeatured) { 
            $this->sort_id = 'featured_'.$feed->id;          
        }

        if($feed->ispublished) { 
            $this->sort_id = 'published_'.$feed->id;          
        }

        $this->feed_data = $feed;
    }
}
