<?php namespace Feedback\Services;

use Feedback\Repositories\DBSocialFeedback;

class SocialFeedback {

    private $socialfeeds;
    private $dbsocial;

    public function __construct($socialfeeds) {
        $this->socialfeeds = $socialfeeds;     
        $this->dbsocial    = new DBSocialFeedback;
    }

    public function perform() {
        foreach($this->socialfeeds->result as $feed) {
            $this->dbsocial->convert($feed);    
        }
    }
}
