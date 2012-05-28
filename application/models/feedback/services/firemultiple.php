<?php namespace Feedback\Services;

use Feedback\Repositories\DBFeedback, Helpers;

class FireMultiple {

    public $feedback;

    public function __construct($feedback, $feed_ids, $mode) {
        $this->feedback = $feedback;
        $this->feed_ids = $feed_ids;
        $this->mode     = $mode;
    }

    public function execute() {
        
        $message = "Sorry negative feedback cannot be ".(($this->mode == "publish") ? "published" : "featured");
        
        $ok_ratings = array_filter($this->feed_ids, function($obj) { return $obj['rating'] != "POOR"; });
        $poor_ratings = array_filter($this->feed_ids, function($obj) { return $obj['rating'] == "POOR"; });
         
        Helpers::show_data($ok_ratings);
        Helpers::show_data($poor_ratings);
        Helpers::show_data($this->mode);

        //conditions
        /*
        if ($ok_ratings == true and $poor_ratings == true and ($this->mode == "feature" || $this->mode == "publish")) {
            echo json_encode(Array("message" => $message, "return_ids" => $this->feed_ids));
        }

        if ($ok_ratings == null and $poor_ratings and ($this->mode == "feature" || $this->mode == "publish")) {      
            echo json_encode(Array("message" => $message, "return_ids" => $poor_ratings));
        }

        if ($ok_ratings == null and $poor_ratings and $this->mode == "delete") {     
            echo json_encode(Array("message" => "Poor ratings! allow {$this->mode} only", "return_ids" => null));
            $this->_toggle();
        }
 
        if ($ok_ratings and $poor_ratings == null) {     
            echo json_encode(Array("message" => "Ok ratings!", "return_ids" => null)); 
            $this->_toggle();
        }

        if ( $ok_ratings == true and $poor_ratings == true and ($this->mode == 'restore' or $this->mode == 'delete') ) {
            echo json_encode(Array("message" => "Restoring Feeds", "return_ids" => null)); 
            $this->_toggle(); 
        }

        if ($this->mode == 'remove') {
            $this->feedback->_permanent_delete($this->feed_ids);     
        }
        */
    }
    
    private function _toggle() { 
        return $this->feedback->_toggle_multiple($this->mode, $this->feed_ids);
    }
}
