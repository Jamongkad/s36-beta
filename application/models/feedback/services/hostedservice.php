<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Exception, Helpers, StdClass, ArrayIterator, LimitIterator, View, Config;
use redisent;

class HostedService {
    
    public $page_number = 0;
    public $units = 4;
    public $starting_units_onload = 5;
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
        $this->feedback     = new DBFeedback;
        $this->redis    = new redisent\Redis;
        $this->key_name = $this->company_name.":fullpage:data";
    }

    public function fetch_hosted_feedback() {
        $this->collection = $this->collection_data_alt();
        return $this->collection_data_alt();
    }

    public function view_fragment() { 
        if($this->debug == True) {
            Helpers::dump($this->fetch_data_by_set());     
        } else { 
            return View::make('hosted/partials/hosted_feedback_partial_view', 
                Array('collection' => $this->fetch_data_by_set(), 'fb_id' => Config::get('application.fb_id')))->get();
        } 
    }

    public function cached_data($data_obj) {
        return json_decode($data_obj);
    }

    public function collection_data_alt() { 

        $feeds = $this->feedback->televised_feedback_alt($this->company_name);
        Helpers::dump($feeds);
        $collection = Array();

        foreach($feeds->result as $feed) {
            if($feed->isfeatured) { 
                $obj = new StdClass;   
                $obj->sort_id = 'featured_'.$feed->id;          
                $obj->feed_data = $feed;
            }

            if($feed->ispublished) { 
                $obj = new StdClass;   
                $obj->sort_id = 'published_'.$feed->id;          
                $obj->feed_data = $feed;
            }
            $collection[strtotime($feed->head_date_format)][] = $obj;        
        }  
        //Helpers::dump($collection);
        $repack = Array();
        foreach($collection as $date_key => $children) {
            $ctr = 0;            
            $children_collection = Array();
            sort($children);
            foreach($children as $val) {
                $arranged_collection = Array();
                if(($ctr % $this->units) == 0) { 
                    foreach(new LimitIterator(new ArrayIterator($children), $ctr, $this->units) as $fr) {    
                        $arranged_collection[] = $fr;     
                    }
                    $children_collection[] = $arranged_collection;
                    $arranged_collection   = Null;
                }
                $ctr += 1;
            }
            $repack[$date_key]   = $children_collection;
            $children_collection = Null;
        } 
        //clear memory
        $collection = Null; 
        $feeds = Null;
        //Helpers::dump($repack);
        return $repack;
    }

    public function collection_data() {

        $feeds = $this->feedback->televised_feedback($this->company_name);

        $collection = Array();
        $featured_feeds = Array();
        $published_feeds = Array();
        $children_collection = Array();

        $result = $feeds->result;

        foreach($result as $feed) {           
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
                foreach(new LimitIterator(new ArrayIterator($published_feeds), $ctr, $this->units) as $fr) { 
                    $children[] = $fr;     
                }
                $children_collection[] = $children;
            }              
            $ctr += 1;
        }
        
        //Debugger
        if($this->debug == True) {          
            /*
            Helpers::dump('-------------------------');
            Helpers::dump("Featured");
            Helpers::dump($featured_feeds);

            Helpers::dump("Published");
            Helpers::dump($published_feeds);

            Helpers::dump("Children"); 
            Helpers::dump($children_collection);         
            Helpers::dump('-------------------------');
            */
        }

        //pre count for performance.
        $this->featured_count  = count($featured_feeds);
        $this->published_count = count($published_feeds); 

        //decision tree
        foreach($result as $ky => $vl) { 

            $final_node = new StdClass;
            if(isset($featured_feeds[$ky]) || isset($children_collection[$ky])) { 
                $final_node->head = null;
                $final_node->children = null;

                if(isset($featured_feeds[$ky])) {
                    $final_node->head = $featured_feeds[$ky];
                } 

                if(isset($children_collection[$ky])) {
                    $final_node->children = $children_collection[$ky];
                } 

                $collection[] = $final_node;
            } 

        }

        return $collection;
    }
    
    public function scale_feeds() {

        $end = count($this->collection);
        
        $standard_collection = new StdClass;
        $standard_collection->start_collection = Array();
        $standard_collection->end_collection = Array();
        
        if($end > 0) {
            $iter = new ArrayIterator($this->collection);
            
            foreach(new LimitIterator($iter, 0, $this->starting_units_onload) as $fr) { 
                $standard_collection->start_collection[] = $fr;
            }
     
            if($this->starting_units_onload < $end) { 
                foreach(new LimitIterator($iter, $this->starting_units_onload, $end) as $fr) { 
                    $standard_collection->end_collection[] = $fr;
                }
            } 
        }

        return $standard_collection;
    }

    public function expose_collection_data() {
        return $this->collection;     
    }

    public function fetch_data_by_set() {

        if(!$this->page_number) { $this->page_number = 1; }

        if($this->redis->hexists($this->key_name, "set:".$this->page_number)) {
            $data = $this->redis->hget($this->key_name, "set:".$this->page_number);     
            return json_decode($data);
        }
       
    }

    public function build_data() {

        $total_collection = $this->featured_count + $this->published_count;
        $redis_total_set  = (int)$this->redis->hget($this->key_name, 'total:set');       
        
        $key = $this->redis->hgetall($this->key_name);
        if(!$key || $redis_total_set !== $total_collection) {
            //echo "Processing: Insert Data into Redis";
            //insert data into redis
            $this->redis->hset($this->key_name, 'total:set', $total_collection);
            foreach($this->scale_feeds() as $ky => $vl) {
                if($ky == "start_collection") {
                    $this->redis->hset($this->key_name, "set:1", json_encode($vl));
                }

                if($ky == "end_collection") {
                    foreach($vl as $k => $v)  {
                        $index = $k + 2; //page numbers
                        $this->redis->hset($this->key_name, "set:".$index, json_encode($v)); 
                    }
                }   
            }
        } 
    }

    public function bust_hostfeed_data() {
        $this->redis->del($this->key_name); 
    }
}
