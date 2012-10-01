<?php namespace Email\Entities\Types;

abstract class EmailData {

    protected $publisher_email;

    public function get_type() {
        return get_class($this);
    }

    public function set_publisher_email($email) {
        $this->publisher_email = $email;     
        return $this;
    }

    public function get_publisher_email() {
        return $this->publisher_email; 
    }
}
