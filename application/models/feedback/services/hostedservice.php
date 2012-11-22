<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Exception, Helpers, StdClass, ArrayIterator, LimitIterator, View, Config;
use redisent;

class HostedService {
    
    public $page_number = 0;
    public $units = 10;
    public $starting_units_onload = 5;
    public $ignore_cache = False; 
    public $debug = False;

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

    public function view_fragment() { 
        if($this->debug == True) {
            Helpers::dump($this->fetch_data_by_set());     
        } else { 
            return View::make('hosted/partials/hosted_feedback_partial_view', 
                Array('collection' => $this->fetch_data_by_set(), 'fb_id' => Config::get('application.fb_id')))->get();
        } 
    }

    public function fetch_hosted_feedback() { 

        $collection = Array();

        foreach($this->feeds->result as $feed) {

            $head_date = strtotime($feed->head_date_format);
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

            $collection[$head_date][] = $obj;        
            $obj = Null;
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
        //Helpers::dump($repack);
        return $repack;
    }
 
    public function fetch_data_by_set() {

        if(!$this->page_number) { $this->page_number = 1; }

        if($this->redis->hexists($this->key_name, "set:".$this->page_number)) {
            $data = $this->redis->hget($this->key_name, "set:".$this->page_number);     
            return json_decode($data);
        }
       
    }

    public function build_data() {

        $total_collection = (int)$this->feeds->total_rows;
        $redis_total_set  = (int)$this->redis->hget($this->key_name, 'total:set');       
        
        $key = $this->redis->hgetall($this->key_name);
        if(!$key || $redis_total_set !== $total_collection) {
            //echo "Processing: Insert Data into Redis";
            //insert data into redis
            $this->redis->hset($this->key_name, 'total:set', $total_collection);
            /*
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
            */
        } 
    }

    public function bust_hostfeed_data() {
        $this->redis->del($this->key_name); 
    }
}
