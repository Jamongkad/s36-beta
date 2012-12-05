<?php namespace Feedback\Repositories;

use Underscore\Underscore;
use TwitterOAuth\TwitterOAuth;
use Company\Repositories\DBCompany;
use \Feedback\Entities\FeedbackNode;
use DateTime, StdClass;
use Package, Helpers, Config, DB;
use redisent\Redis;

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
        
        $dbcompany = new DBCompany;
        $this->company = $dbcompany->get_company_info(Config::get('application.subdomain'));
        $this->company_social = DB::Table('CompanySocialAccount', 'master')->where('companyId', '=', $this->company->companyid)->first();
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
            /*
            Package::load('eden');
            eden()->setLoader();       
            eden($this->social_network)->auth($this->twitter_key, $this->twitter_secret);
            $search = eden($this->social_network)->search($this->twitter_key, $this->twitter_secret
                                                        , $this->access_token, $this->access_secret);
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
            */
            $token_credentials = Helpers::unwrap($this->company_social->socialaccountvalue);
            Helpers::dump($token_credentials);
            /*
            $connection = new TwitterOAuth($this->twitter_key, $this->twitter_secret, $token_credentials['oauth_token'], $token_credentials['oauth_token_secret']); 
            $tweets = $connection->get('statuses/home_timeline');
            $collection = Array();
            foreach($tweets as $tweet) {
                $dt = new DateTime($tweet->created_at);
                $node = new StdClass;
                $node->id             = $tweet->id_str;
                $node->firstname      = $tweet->user->name;
                $node->screen_name    = $tweet->user->screen_name;
                $node->avatar         = $tweet->user->profile_image_url_https;
                $node->text           = $tweet->text;
                $node->twit_date      = $tweet->created_at;
                $node->feed_type      = 'tw';
                $node->daysago        = Helpers::relative_time($dt->getTimestamp());
                $node->date           = $dt->format("Y-m-d H:i:s");
                $node->head_date      = $dt->format("d.m.Y");
                $node->unix_timestamp = $dt->getTimestamp();
                $node->datetimeobj    = $dt; 
                $collection[] = $node;
            }
            */
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
