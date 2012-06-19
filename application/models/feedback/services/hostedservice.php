<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Exception, Helpers, StdClass, ArrayIterator, LimitIterator, View, Config;
use Halcyonic, redisent;

class HostedService {
    
    public $page_number = 0;
    public $units = 4;
    public $limit = 8;
    public $offset = 0;
    public $ignore_cache = False; 
    public $debug = False;

    private $collection;
    private $html;
    private $num_rows;
    private $number_of_pages;
    private $pages;
    
    public function __construct($company_name) {
        $this->company_name = $company_name;
        $this->feedback = new DBFeedback;
        $this->cache = new Halcyonic\Services\Cache;
        $this->redis = new redisent\Redis;
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
        $this->collection = $collection;

        if($this->debug == False) { 
            $this->html = View::make(  'hosted/partials/hosted_feedback_partial_view'
                                         , Array('collection' => $collection, 'fb_id' => Config::get('application.fb_id'))
                                        )->get();

            $this->num_rows = $feeds->total_rows;
            $this->number_of_pages = $feeds->number_of_pages;
            $this->pages = $feeds->pages;
        }

        if(!$this->ignore_cache) {
            $this->cache->set_cache($collection);                                                                              
        }
        /*
        $data_obj = new StdClass;
        $data_obj->collection = $collection;
        
        if($this->debug == False) { 
            $data_obj->html = View::make(  'hosted/partials/hosted_feedback_partial_view'
                                         , Array('collection' => $collection, 'fb_id' => Config::get('application.fb_id'))
                                        )->get();

            $data_obj->num_rows = $feeds->total_rows;
            $data_obj->number_of_pages = $feeds->number_of_pages;
            $data_obj->pages = $feeds->pages;
        }

        if(!$this->ignore_cache) {
            $this->cache->set_cache($data_obj);                                                                              
        }

        return $data_obj; 
        */
    }

    public function return_collection() {
        return $this->collection;     
    }

    public function return_html() { 
        return $this->html;     
    }

    public function cached_data($data_obj) {
        return json_decode($data_obj);
    }

    public function collection_data($feeds) {
        
        $collection = Array();
        $featured_feeds = Array();
        $published_feeds = Array();
        $children_collection = Array();

        foreach($feeds->result as $feed) {           
            if($feed->isfeatured == 0 and $feed->ispublished == 1) {
                if($this->debug == True) { 
                    $published_feeds[] = Array($feed->id, $feed->date);                   
                } else {
                    $published_feeds[] = $feed;                   
                }

            } else {
                if($this->debug == True) { 
                    $featured_feeds[] = Array($feed->id, $feed->date); //$feed->id;
                } else {
                    $featured_feeds[] = $feed;
                } 
            }
        }

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
        
        //Debugger
        if($this->debug == True) { 
            /*
            Helpers::dump("Featured");
            Helpers::dump($featured_feeds);

            Helpers::dump("Published");
            Helpers::dump($published_feeds);

            Helpers::dump("Children"); 
            Helpers::dump($children_collection);        
            */
        }

        //pre count for performance.
        $featured_count = count($featured_feeds);
        $published_count = count($published_feeds);
        
        //decision tree
        if($featured_count == 1)  {
            $final_node = new StdClass; 
            $final_node->head = $featured_feeds[0];
            $final_node->children = $published_feeds; 
            $collection[] = $final_node;
        } else if($featured_count == 0 and $published_count > 0) {
            $final_node = new StdClass; 
            $final_node->children = $published_feeds;
            $collection[] = $final_node;
        } else { 
            for($i=0; $i < $featured_count && $i < $children_collection; $i++) {
                $final_node = new StdClass;
                $final_node->head = $featured_feeds[$i];
                if(isset($children_collection[$i])) {
                    $final_node->children = $children_collection[$i];
                }
                $collection[] = $final_node;
            }
        }

        return $collection;
    }

    public function build_data() {
        $total_collection = count($this->collection);
        
        $key_name = $this->company_name.":fullpage:data";
        $total_set = $this->redis->hget($key_name, 'total:set');
        
        $key = $this->redis->hgetall($key_name);
        if(!$key || $total_set != $total_collection) {
            echo "Processing required";
            //process data into redis
            Helpers::dump($total_collection);
            Helpers::dump($total_set);
            Helpers::dump($key);     
        } else {
            echo "No processing required";
        }
    }

    public function invalidate_hosted_feeds_cache() {
        return $this->cache->invalidate_cache();
    }
}
