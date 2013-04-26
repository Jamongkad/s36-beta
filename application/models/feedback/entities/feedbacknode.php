<?php namespace Feedback\Entities;

use StdClass;
use Helpers;

class FeedbackNode {

    private $data;
    private $additional_data;

    public function __construct($data) {
        $this->data = $data;     
    }

    public function set_additional_data($data) {
        $this->additional_data = $data; 
    }

    public function generate() {
        
        $node = new StdClass; 
        foreach($this->data as $key => $value) {
            if($key) { 
                $node->$key = $value;
                if($key == 'metadata' || $key == 'attachments') {
                    $node->$key = json_decode($value);
                }
                if($key == 'id') {
                    $node->$key = 'mathew';
                }
            } 
        }
        return $node;
    }    
}
