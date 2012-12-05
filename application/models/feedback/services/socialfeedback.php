<?php namespace Feedback\Services;

use Feedback\Repositories\DBSocialFeedback;
use Exception;

class SocialFeedback {

    private $socialfeeds;
    private $dbsocial;

    public function __construct(Array $socialfeeds, $dbsocial) {
        $this->socialfeeds = $socialfeeds;     
        $this->dbsocial    = $dbsocial;
    }

    public function save_social_feeds($social) {
        $social_fd = $this->socialfeeds[$social];
        return $social_fd;
        /*
        if($social_feed = $social_fd->result) { 
            foreach($social_feed as $feed) {
                $this->dbsocial->convert($feed);    
            }
            return true;
        } else {     
            throw new Exception("Social Feed is missing!");
        }
        */
    }
}
