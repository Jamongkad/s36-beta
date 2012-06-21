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

    private $featured_count;
    private $published_count;
    
    public function __construct($company_name) {
        $this->company_name = $company_name;
        $this->feedback = new DBFeedback;
        $this->cache = new Halcyonic\Services\Cache;
        $this->redis = new redisent\Redis;

        $this->key_name = $this->company_name.":fullpage:data";
    }

    public function fetch_hosted_feedback() {
        $this->collection = $this->collection_data(); 
    }

    public function view_fragment() { 
        return View::make('hosted/partials/hosted_feedback_partial_view', 
            Array('collection' => $this->fetch_data_by_set(), 'fb_id' => Config::get('application.fb_id'))
        )->get();
    }

    public function cached_data($data_obj) {
        return json_decode($data_obj);
    }

    public function collection_data() {

        $feeds = $this->feedback->televised_feedback($this->company_name);

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
                    $featured_feeds[] = Array($feed->id, $feed->date); 
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
        $this->featured_count  = count($featured_feeds);
        $this->published_count = count($published_feeds);
        
        //decision tree
        if($this->featured_count == 1)  {
            $final_node = new StdClass; 
            $final_node->head = $featured_feeds[0];
            $final_node->children = $published_feeds; 
            $collection[] = $final_node;
        } else if($this->featured_count == 0 and $this->published_count > 0) {
            $final_node = new StdClass; 
            $final_node->children = $published_feeds;
            $collection[] = $final_node;
        } else { 
            for($i=0; $i < $this->featured_count && $i < $children_collection; $i++) {
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

    public function expose_collection_data() {
        return $this->collection;     
    }

    public function fetch_data_by_set() {

        if(!$this->page_number) { 
            $this->page_number = 1; 
        }

        $key_exists = $this->redis->hexists($this->key_name, "set:".$this->page_number);
        if($key_exists) {
            $data = $this->redis->hget($this->key_name, "set:".$this->page_number);     
            return json_decode($data);
        }
       
    }

    public function build_data() {

        $key_name = $this->company_name.":fullpage:data";
        $total_collection = $this->featured_count + $this->published_count;
        $total_set        = (int)$this->redis->hget($this->key_name, 'total:set');       

        $key = $this->redis->hgetall($this->key_name);
        if(!$key || $total_set !== $total_collection) {
            echo "Processing";
            //process data into redis
            $this->redis->hset($key_name, 'total:set', $total_collection);
            foreach($this->collection as $ky => $vl) {
                $index = $ky + 1;
                $this->redis->hset($key_name, "set:".$index, json_encode($vl));
            }
        } else {
            echo "No processing";
        }
    }

    public function bust_hostfeed_data() {
        $this->redis->del($this->key_name); 
    }
}
