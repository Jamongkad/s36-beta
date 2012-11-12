<?php namespace Feedback\Repositories;

use Underscore\Underscore;
use \Feedback\Entities\FeedbackNode;
use DateTime, StdClass;
use Package, Helpers, Config;

Package::load('eden');

class TWFeedback {
    public function __construct() { 
        $this->twitter_key    = Config::get('application.dev_twitter_key');
        $this->twitter_secret = Config::get('application.dev_twitter_secret');
        $this->access_token   = Config::get('application.dev_twitter_access_token');
        $this->access_secret  = Config::get('application.dev_twitter_access_secret');
    }

    public function pull_tweets_for($twitter_account) {
        eden()->setLoader();       
        eden('twitter')->auth($this->twitter_key, $this->twitter_secret);
        $search = eden('twitter')->search($this->twitter_key, $this->twitter_secret, $this->access_token, $this->access_secret);
        $tweets  = $search->search($twitter_account); 

        $collection = Array();
        foreach($tweets['statuses'] as $data) {  
            $dt = new DateTime($data['created_at']);
            $node = new FeedbackNode;
            $node->id             = $data['id_str'];
            $node->firstname      = $data['user']['name'];
            $node->screen_name    = $data['user']['screen_name'];
            $node->avatar         = $data['user']['profile_image_url_https'];
            $node->text           = $data['text'];
            $node->twit_date      = $data['created_at'];
            $node->feed_type      = 'tw';
            $node->daysago        = Helpers::relative_time($dt->getTimestamp());
            $node->date           = $dt->format("Y-m-d H:i:s");
            $node->head_date      = $dt->format("d.m.Y");
            $node->unix_timestamp = $dt->getTimestamp();
            $node->datetimeobj    = $dt; 
            $collection[] = $node;
        }

        $obj = new StdClass;
        $obj->result = $collection;
        return $obj;
    }

    public function get_rate_limit() { 
        eden()->setLoader();       
        eden('twitter')->auth($this->twitter_key, $this->twitter_secret);
        $help = eden('twitter')->help($this->twitter_key, $this->twitter_secret, $this->access_token, $this->access_secret);
        $resources = 'search';
        $result = $help->getRateLimitStatus($resources);
        return $result;
    }
}
