<?php namespace Feedback\Entities;

use StdClass;
use Helpers;

class FeedbackNode {

    private $data;

    public function __construct($data) {
        $this->data = $data;     
    }

    public function generate() {
        $node = new StdClass; 
        foreach($this->data as $key => $value) {
            if($key) { 
                $node->$key = $value;
                if($key == 'metadata' || $key == 'attachments') {
                    $node->$key = json_decode($value);
                }
            } 
        }

        return $node;
    }    
}
