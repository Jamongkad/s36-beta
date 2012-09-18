<?php namespace Feedback\Services;

use DB;

class FeedbackActivity {

    private $table = 'FeedbackActivity';
    private $db = 'master';

    public function __construct($user_id, $feedback_id, $status) {
        $this->user_id = $user_id;     
        $this->feedback_id = $feedback_id;
        $this->status = $status;
    }

    public function log_activity() {
        if($this->check_activity_status()) {
            return $this->check_activity_status();
        } else {
            return $this->insert_new_activity();
        }
    }

    public function check_activity_status()  {
        $db_check = DB::Table($this->table, $this->db)
                        ->join('User', 'User.userId', '=', 'FeedbackActivity.userId')
                        ->where('FeedbackActivity.feedbackId', '=', $this->feedback_id)
                        ->where('FeedbackActivity.feedbackStatus', '=', $this->status)
                        ->first();

        return $db_check;
    }

    public function insert_new_activity() {
        $affected = DB::Table($this->table, $this->db)->insert(Array(
            'userId' => $this->user_id
          , 'feedbackId' => $this->feedback_id
          , 'feedbackStatus' => $this->status
          , 'dtAdded' => date('Y-m-d H:i:s', time())
        ));
        return $affected; 
    }

    public function delete_activity() {
        DB::Table($this->table, $this->db)->where('userId', '=', $this->user_id)->delete();
    }
    
    //hmmmmm subject to approval muthafucka
    //Not yet being used
    /*
    public function update_activity_status() { 
        $affected = DB::Table('FeedbackActivity', 'master')
            ->where('userId', '=', $this->user_id)
            ->where('feedbackId', '=', $this->feedback_id)
            ->update(Array(
                'userId' => $this->user_id
              , 'feedbackId' => $this->feedback_id
              , 'feedbackStatus' => $this->status
              , 'dtAdded' => date('Y-m-d H:i:s', time())
            ));
        return $affected; 
    }
    */
}
