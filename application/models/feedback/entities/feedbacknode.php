<?php namespace Feedback\Entities;

class FeedbackNode {

    private $data = Array();

    public function set($data) {
        $this->data[$data] = $data;
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
