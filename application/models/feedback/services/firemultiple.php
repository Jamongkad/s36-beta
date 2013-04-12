<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Helpers, S36Auth;
use Feedback\Services\FeedbackState;
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
        //emits json for jquery ui manipulation
        $this->_group_ui_cluster($this->feed_ids);

        if($this->mode == "remove") {
            foreach($this->feed_ids as $feed_id) {
                $this->feedback->permanently_remove_feedback($feed_id['feedid']);    
            } 
        } else {  
            $feedbackstate = new FeedbackState($this->mode, $this->feed_ids, $this->company_id);
            $feedbackstate->change_state();
            $feedbackstate->write_summary();
        } 

    }

    private function _group_ui_cluster($feeds) {
         
        $group = $this->underscore->groupBy($feeds, 'parent_id');
        $company_key = "inbox:check-action:".$this->company_id;

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
             
            $message = null;
            if($this->mode == 'publish') {
                $message = "Feedback has been published.";
            }
            
            if($this->mode == 'feature') {
                $message = "Feedback has been featured.";
            }

            if($this->mode == 'delete') {
                $message = "Feedback has been deleted.";
            }

            if($this->mode == 'restore') {
                $message = "Feedback has been restored.";
            }

            echo json_encode(Array('ui' => $obj, 'message' => $message));
        }  
    }    
}
