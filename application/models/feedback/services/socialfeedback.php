<?php namespace Feedback\Services;

use Feedback\Repositories\DBSocialFeedback;

class SocialFeedback {

    private $socialfeeds;
    private $dbsocial;

    public function __construct(Array $socialfeeds, $dbsocial) {
        $this->socialfeeds = $socialfeeds;     
        $this->dbsocial    = $dbsocial;
    }

    public function save_social_feeds() {
        $twitter = $this->socialfeeds['twitter'];
        if($tw = $twitter->result) { 
            foreach($tw as $feed) {
                $this->dbsocial->convert($feed);    
            }
        }
    }

    public function clear_social_feeds() {
        $this->dbsocial->delete_all();     
    }
}
