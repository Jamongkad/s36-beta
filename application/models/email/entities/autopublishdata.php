<?php namespace Email\Entities;

use Email\Entities\Types\EmailData;

class AutopublishData extends EmailData {
    
    public function set_feedback($feedback) {
        $this->feedback = $feedback; 
        return $this;
    }

    public function set_sendtoaddresses($address) { 
        $this->sendto_addresses = $address; 
        return $this;
    }

    public function get_feedback() { 
        return $this->feedback;
    }
    
    public function get_addresses() { 
        return $this->sendto_addresses;
    }

}