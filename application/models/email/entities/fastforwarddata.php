<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;

class FastForwardData extends EmailData {

    public $sendto;
    public $message;
    public $from; 

    private $feedback;
 
    public function set_feedback($feedback) {
        $this->feedback = $feedback; 
        return $this;
    }
}
