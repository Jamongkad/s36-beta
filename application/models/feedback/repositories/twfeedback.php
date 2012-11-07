<?php namespace Feedback\Repositories;

use Underscore\Underscore;
use \Feedback\Entities\FeedbackNode;
use DateTime, StdClass;
use Package, Helpers, Config;

Package::load('eden');

class TWFeedback {
    public function __construct() { 
        $this->twitter_key    = Config::get('application.twitter_key');
        $this->twitter_secret = Config::get('application.twitter_secret');
        $this->access_token   = Config::get('application.twitter_access_token');
        $this->access_secret  = Config::get('application.twitter_access_secret');
    }

    public function pull_tweets_for($twitter_account) {
        eden()->setLoader();       
        eden('twitter')->auth($this->twitter_key, $this->twitter_secret);
        $search = eden('twitter')->search($this->twitter_key, $this->twitter_secret, $this->access_token, $this->access_secret);
        $tweets  = $search->search($twitter_account); 

        $collection = Array();
        foreach($tweets['statuses'] as $data) {  
            $d = new DateTime($data['created_at']);

            $node = new FeedbackNode;
            $node->id             = $data['id_str'];//$data['user']['id_str'];
            $node->firstname      = $data['user']['name'];
            $node->screen_name    = $data['user']['screen_name'];
            $node->avatar         = $data['user']['profile_image_url_https'];
            $node->text           = $data['text'];
            $node->twit_date      = $data['created_at'];
            $node->feed_type      = 'tw';
            $node->daysago        = Helpers::relative_time($d->getTimestamp());
            $node->date           = $d->format("Y-m-d H:i:s");
            $node->head_date      = $d->format("d.m.Y");
            $node->unix_timestamp = $d->getTimestamp();
            $node->datetimeobj    = $d; 
            $collection[] = $node;
        }

        $obj = new StdClass;
        $obj->status = $tweets['statuses'];
        $obj->result = $collection;

        return $obj;
    }
}
