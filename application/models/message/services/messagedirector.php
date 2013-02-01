<?php namespace Message\Services;

use Message\Repositories\UserDirectory;

class MessageDirector {
    
    public function __construct() {
        $this->directory = new UserDirectory;
    }
}
