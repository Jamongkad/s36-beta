<?php namespace Feedback\Repositories;

use Underscore\Underscore;
use \Feedback\Entities\FeedbackNode;
use DateTime, StdClass;
use Package, Helpers, Config;
use redisent\Redis;

Package::load('eden');

class TWFeedback {

    public $request_count = 3;

    public function __construct() { 
        $this->twitter_key    = Config::get('application.dev_twitter_key');
        $this->twitter_secret = Config::get('application.dev_twitter_secret');
        $this->access_token   = Config::get('application.dev_twitter_access_token');
        $this->access_secret  = Config::get('application.dev_twitter_access_secret');
        $this->social_network = 'twitter';
        $this->redis          = new Redis;
        $this->redis_twitter_key = Config::get('application.subdomain').':twitter:feedback';
    }

    public function pull_tweets_for($twitter_account) {

        $timestamp = strtotime('tomorrow');
        $collection = Null; 

        $request_count_check = $this->redis->hget($this->redis_twitter_key, 'requests') != $this->request_count;

        if($this->redis->hgetall($this->redis_twitter_key)) {   
            if($request_count_check) {
                $this->redis->hincrby($this->redis_twitter_key, 'requests', 1);     
            } 
        } else {
            $this->redis->hsetnx($this->redis_twitter_key, 'requests', 0);  
            $this->redis->expireat($this->redis_twitter_key, $timestamp);
        }

        if($request_count_check) {
            eden()->setLoader();       
            eden($this->social_network)->auth($this->twitter_key, $this->twitter_secret);
            $search = eden($this->social_network)->search($this->twitter_key, $this->twitter_secret
                                                        , $this->access_token, $this->access_secret);
            $tweets  = $search->search($twitter_account); 
            
            Helpers::dump($tweets);


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
        }
  
        $obj = new StdClass;
        $obj->result = $collection;
        return $obj;

    }

    public function reset_request_count() {
        $this->redis->del($this->redis_twitter_key);   
    }

    public function get_rate_limit() { 
        eden()->setLoader();       
        eden($this->social_network)->auth($this->twitter_key, $this->twitter_secret);
        $help = eden($this->social_network)->help($this->twitter_key, $this->twitter_secret, $this->access_token, $this->access_secret);
        $resources = 'search';
        $result = $help->getRateLimitStatus($resources);
        return $result;
    }
}
