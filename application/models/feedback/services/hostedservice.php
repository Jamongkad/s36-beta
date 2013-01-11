<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Feedback\Entities\FeedbackLeaf;
use redisent;
use Helpers, View;
use Exception, StdClass, ArrayIterator, LimitIterator;


class HostedService {
    
    public $page_number = 0;
    public $units = 10;
    public $starting_units_onload = 5;
    public $ignore_cache = False; 
    public $debug = False;
    public $dump_build_data = False;

    private $collection;
    private $html;
    private $num_rows;
    private $number_of_pages;
    private $pages;
    private $feeds;

    private $featured_count;
    private $published_count;
    
    public function __construct($company_name) {
        $this->redis    = new redisent\Redis;
        $this->key_name = $company_name.":fullpage:data";

        $feedback = new DBFeedback;
        $this->feeds = $feedback->televised_feedback_alt($company_name);
    }

    public function fetch_hosted_feedback() { 

        $collection = Array();
        foreach($this->feeds->result as $feed) {
            $head_date = strtotime($feed->head_date_format);
            $collection[$head_date][] = $this->_build_leaf($feed);
            $head_date = Null;
        }  

        $repack = Array();
        foreach($collection as $date_key => $children) {
            $ctr = 0;            
            $children_collection = Array();
            sort($children);
            $units = count($children);
            foreach($children as $val) {
                $arranged_collection = Array();
                if(($ctr % $units) == 0) { 
                    foreach(new LimitIterator(new ArrayIterator($children), $ctr, $units) as $fr) {    
                        $arranged_collection[] = $fr;     
                    }
                    $children_collection[] = $arranged_collection;
                    $arranged_collection   = Null;
                }
                $ctr += 1;
            }
            $repack[$date_key]   = $children_collection[0];
            $children_collection = Null;
        } 
        //clear memory
        $collection = Null; 
        $feeds = Null;
        
        if($this->dump_build_data == True) {
            Helpers::dump($repack);      
        }
       
        return $repack;
    }
 
    public function fetch_data_by_set() {

        if(!$this->page_number) { $this->page_number = 1; }

        if($this->redis->hexists($this->key_name, "set:".$this->page_number)) {
            $data = $this->redis->hget($this->key_name, "set:".$this->page_number);     
            return json_decode($data);
        }
       
    }

    public function _build_leaf($feed) {

        if($this->debug == True) {   
            $obj = new StdClass;   
            $obj->sort_id = $feed->id;
            $obj->isfeatured = $feed->isfeatured;
            $obj->ispublished = $feed->ispublished;
            $obj->feed_data = $feed;

            return $obj;
        } else { 
            return new FeedbackLeaf($feed);  
        }
    }

    public function build_data() {

        $total_collection = (int)$this->feeds->total_rows;
        $redis_total_set  = (int)$this->redis->hget($this->key_name, 'total:set');       
 
        $key = $this->redis->hgetall($this->key_name);
        $hosted_feeds = $this->fetch_hosted_feedback();       

        if($this->debug == True) {
            echo "<h1>HostedService Debug Enabled!</h1>";
            if($this->bust_hostfeed_data()) {
                echo "<h2>Cache Busted</h2>";     
            } 
        } else { 
            if($this->ignore_cache == True) {
                echo "<h2>Cache Ignored</h2>";
            } else { 
                if(!$key || $redis_total_set !== $total_collection) {
                    //echo "Processing: Insert Data into Redis";
                    //insert data into redis
                    $this->redis->hset($this->key_name, 'total:set', $total_collection);
                    $page = 0;
                    foreach($hosted_feeds as $feed_group => $feed_list) {
                        $page_number = ++$page;
                        $spring_data = Array($feed_group => $feed_list);
                        $this->redis->hset($this->key_name, "set:$page_number", json_encode($spring_data));
                        $spring_data = Null;
                    }
                } 
            }
        }
    }

    public function bust_hostfeed_data() {
        return $this->redis->del($this->key_name); 
    }
}
