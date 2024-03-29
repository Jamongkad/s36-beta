<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Feedback\Entities\FeedbackLeaf;
use redisent;
use Helpers, View;
use Exception, StdClass, ArrayIterator, LimitIterator;


class HostedService {
    
    public $page_number = 0;
    public $units = 10;
    public $starting_units_onload = 5;
    public $feed_advance_count = 6;
    public $debug = False;
    public $dump_build_data = False;

    private $collection;
    private $html;
    private $num_rows;
    private $number_of_pages;
    private $pages;
    private $feeds;
    private $layout;

    private $featured_count;
    private $published_count;

    private $total_collection;
    
    public function __construct($company_name, $feeds=Null, $layout=Null) {
        $this->redis    = new redisent\Redis;
        $this->key_name = $company_name.":fullpage:data";
        $this->feeds    = $feeds;
        $this->layout   = strtolower($layout);
    }

    public function group_and_build() { 

        $collection = Array();
        foreach($this->feeds as $feed) {
            $head_date = strtotime($feed->head_date_format);
            $collection[$head_date][] = $this->_build_leaf($feed);
            $head_date = Null;
        }  

        $repack = Array();
        foreach($collection as $date_key => $children) {
            if($this->layout == 'traditional') {
                $repack[$date_key] = $children;
            } else {
                //holy fuck what is this shit?!?!
                //inserts feed insertion order with featured first order by date. 
                foreach($children as $child) {

                    $isfeatured = null;

                    if(property_exists($child, 'feed_data')) {
                       $isfeatured = $child->feed_data->isfeatured;
                    } else {
                       $isfeatured = $child->isfeatured;     
                    }

                    if($isfeatured == 1) {
                        $repack[$date_key][] = $child;
                    }   
                }

                foreach($children as $child) {

                    $ispublished = null;

                    if(property_exists($child, 'feed_data')) {
                       $ispublished = $child->feed_data->ispublished;
                    } else {
                       $ispublished = $child->ispublished;     
                    }

                    if($ispublished == 1) {
                        $repack[$date_key][] = $child;
                    }
                }
            } 
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
            $obj->date = $feed->date;
            $obj->title = $feed->title;

            return $obj;
        } else { 
            return new FeedbackLeaf($feed);  
        }
    }

    public function build_data() {

        //We want to generalize this algorithm
        $this->total_collection = (int)count($this->feeds);
        $redis_total_set  = (int)$this->redis->hget($this->key_name, 'total:set');       
 
        $key = $this->redis->hgetall($this->key_name);
        $hosted_feeds = $this->group_and_build();       

        if(!$key || $redis_total_set !== $this->total_collection) {
            //echo "Processing: Insert Data into Redis";
            //insert data into redis
            $this->redis->hset($this->key_name, 'total:set', $this->total_collection);
            $page = 0;
            foreach($hosted_feeds as $feed_group => $feed_list) {
                $page_number = ++$page;
                $spring_data = Array($feed_group => $feed_list);
                $this->redis->hset($this->key_name, "set:$page_number", json_encode($spring_data));
                $spring_data = Null;
            }
        } 
        
    }

    public function bust_hostfeed_data() {
        return $this->redis->del($this->key_name); 
    }

    //method to determine feedback rendering.
    public function determine_feed_advance() {
        if($this->total_collection >= $this->feed_advance_count) {
            return 6;     
        } else {
            return 1;     
        }
    }
}
