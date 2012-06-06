<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Exception, Helpers, StdClass, ArrayIterator, LimitIterator, View, Config;
use Halcyonic;

class HostedService {
    
    public $page_number = 0;
    public $units = 4;
    public $limit = 8;
    public $offset = 0;
    public $ignore_cache = False; 
    
    public function __construct($company_name) {
        $this->company_name = $company_name;
        $this->feedback = new DBFeedback;
        $this->cache = new Halcyonic\Services\Cache;
    }

    public function fetch_hosted_feedback() {

        if(!$this->page_number) { $this->page_number = 1; }
        $this->offset = ($this->page_number - 1) * $this->limit;
        
        $this->cache->key_name = "hosted:feeds";
        $this->cache->filter_array = Array(
            'page_no' => $this->page_number
          , 'units' => $this->units
          , 'limit' => $this->limit
          , 'offset' => $this->offset
          , 'company_name' => $this->company_name
        );

        $this->cache->generate_keys();

        if($this->ignore_cache or !$data_obj = $this->cache->get_cache()) { 
            return $this->original_data();
        } else { 
            return $this->cached_data($data_obj);
        }
    }

    public function original_data() { 
        
        $feeds = $this->feedback->televised_feedback($this->company_name, $this->offset, $this->limit);
        $collection = $this->collection_data($feeds);

        $data_obj = new StdClass;
        $data_obj->collection = $collection;
        /*
        $data_obj->html = View::make(  'hosted/partials/hosted_feedback_partial_view'
                                     , Array('collection' => $collection, 'fb_id' => Config::get('application.fb_id')))->get();
        $data_obj->num_rows = $feeds->total_rows;
        $data_obj->number_of_pages = $feeds->number_of_pages;
        $data_obj->pages = $feeds->pages;
        */

        if(!$this->ignore_cache) {
            $this->cache->set_cache($data_obj);               
        }

        return $data_obj; 

    }

    public function cached_data($data_obj) {
        return json_decode($data_obj);
    }

    public function collection_data($feeds) {
        
        $collection = Array();
        $featured_feeds = Array();
        $published_feeds = Array();
        $children_collection = Array();

        #Helpers::dump("All Feeds");
        #Helpers::dump($feeds->result);
    
        foreach($feeds->result as $feed) {           
            if($feed->isfeatured == 0 and $feed->ispublished == 1) {
                $published_feeds[] = $feed->id;
            } else {
                $featured_feeds[] = $feed->id;
            }
        }
        Helpers::dump("Featured");
        Helpers::dump($featured_feeds);

        Helpers::dump("Published");
        Helpers::dump($published_feeds);

        $ctr = 0;            
        foreach($published_feeds as $published_feed) {
            $children = Array();
            if(($ctr % $this->units) == 0) { 
                $iter = new ArrayIterator($published_feeds);
                foreach(new LimitIterator($iter, $ctr, $this->units) as $fr) { 
                    $children[] = $fr;     
                }
                $children_collection[] = $children;
            }              
            $ctr += 1;
        }

        Helpers::dump("Children"); 
        Helpers::dump($children_collection);

        //$combined = array_combine($featured_feeds, $children_collection);
        //Helpers::dump($combined);
        /*        
        foreach($children_collection as $key => $val) {

            $final_node = new StdClass;   
            if(isset($featured_feeds[$key])) {
                $final_node->head = $featured_feeds[$key];      
                $final_node->children = $val;
            }  
            //$final_node->head = $featured_feeds[$key];     
            $collection[] = $final_node;

        }          
        */

        foreach($featured_feeds as $feed_key => $feed_val) {
            $final_node = new StdClass;   
            foreach($children_collection as $child_key => $child_val) {
                if($feed_key === $child_key) {
                    $final_node->head = $feed_val; 
                } else {
                    $final_node->detached_head = $feed_val;
                }
            }

            $collection[] = $final_node;
        }
        return $collection;
    }

    public function invalidate_hosted_feeds_cache() {
        return $this->cache->invalidate_cache();
    }
}
