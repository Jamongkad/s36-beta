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
        if($social_feed = $social_fd->result) { 
            foreach($social_feed as $feed) {
                $this->dbsocial->convert($feed);    
            }
        } else {     
            throw new Exception("Social Feed is missing!");
        }

    }

    public function clear_social_feeds($social) {
        if($social) {
            $this->dbsocial->delete_all($social);          
        } else {
            throw new Exception("You must provide a Social Network abbrevation! fb, tw, g+");
        }
       
    }
}
