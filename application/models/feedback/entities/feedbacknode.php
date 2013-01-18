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

    
    /*
    public function __get($name) {
        if(array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): '  . $name .
            ' in ' . $trace[0]['file'] . 
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );
        return null;
    }
    */
}
