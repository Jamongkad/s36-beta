<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Helpers, S36Auth;
use Underscore, redisent;

class FireMultiple {

    public $feedback;

    public function __construct($feedback, $feed_ids, $mode) {
        $this->redis = new redisent\Redis; 
        $this->underscore = new Underscore\Underscore;
        $this->company_id = S36Auth::user()->companyid;
        $this->feedback = $feedback;
        $this->feed_ids = $feed_ids;
        $this->mode     = $mode; 
    }

    public function execute() {
        
        $message = "Sorry negative feedback cannot be ".(($this->mode == "publish") ? "published" : "featured"); 
        $ok_ratings = array_filter($this->feed_ids, function($obj) { return $obj['rating'] != "POOR"; });
        $poor_ratings = array_filter($this->feed_ids, function($obj) { return $obj['rating'] == "POOR"; });
        $parent_ids = array_unique(array_map(function($obj) { return $obj['parent_id']; }, $this->feed_ids));
        
        $clustered_groups = $this->_group_cluster($this->feed_ids);

        return $clustered_groups; 
        /*
        Helpers::show_data($ok_ratings);
        Helpers::show_data($poor_ratings);
        Helpers::show_data($this->mode);
        */

        //conditions
        /*
        if ($ok_ratings == true and $poor_ratings == true and ($this->mode == "feature" || $this->mode == "publish")) {
            echo json_encode(Array("message" => $message, "mode" => $this->mode, "return_ids" => $this->feed_ids));
        }

        if ($ok_ratings == null and $poor_ratings and ($this->mode == "feature" || $this->mode == "publish")) {      
            echo json_encode(Array("message" => $message, "mode" => $this->mode, "return_ids" => $poor_ratings));
        }

        if ($ok_ratings == null and $poor_ratings and $this->mode == "delete") {     
            echo json_encode(Array("message" => "Poor ratings! allow {$this->mode} only", "mode" => $this->mode, "return_ids" => null));
            //$this->_toggle();
        }
 
        if ($ok_ratings and $poor_ratings == null) {     
            echo json_encode(Array("message" => "Ok ratings! mode: {$this->mode}", "mode" => $this->mode, "return_ids" => null)); 
            //$this->_toggle();
        }

        if ( $ok_ratings == true and $poor_ratings == true and ($this->mode == 'restore' or $this->mode == 'delete') ) {
            echo json_encode(Array("message" => "Restoring Feeds", "mode" => $this->mode, "return_ids" => null)); 
            //$this->_toggle(); 
        }

        if ($this->mode == 'remove') {
            echo json_encode(Array("message" => "Deleting Feeds", "mode" => $this->mode, "return_ids" => null)); 
            //$this->feedback->_permanent_delete($this->feed_ids);     
        }
        */
    }

    private function _group_cluster($feeds) {
         
        $ratings = $this->underscore->groupBy($feeds, 'rating');
        $group = $this->underscore->groupBy($feeds, 'parent_id');
        $company_key = "inbox:check-action:".$this->company_id;

        Helpers::dump($ratings);

        foreach($group as $key => $val) {
            
            $first = $this->underscore->first($val);
            $total_units = $first['total_units'];

            $this->redis->hset($company_key, $key, null);
            foreach($val as $v) {
                $this->redis->sadd($key, $v['feedid']."-".$this->mode);     
            }

            $total_mems = $this->redis->smembers($key);
            if($total_units == count($total_mems)) {
                $this->redis->hset($company_key, $key, "full");
            }
        } 

        if($hkeys = $this->redis->hkeys($company_key)) {
            $obj = Array();
            foreach($hkeys as $hseek) {  
                $is_full = $this->redis->hget($company_key, $hseek);
                if($is_full) { 
                    $members = $this->redis->smembers($hseek);
                    $obj[$hseek] = $members;
                }
            }
            //Helpers::dump($obj);
            //echo json_encode($obj);
        }  

        //poor no mysql toggle
    }
    
    private function _toggle() { 
        return $this->feedback->_toggle_multiple($this->mode, $this->feed_ids);
    }
}
