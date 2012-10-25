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

    public function pull_twits_for($twitter_account) {
        eden()->setLoader();       
        eden('twitter')->auth($this->twitter_key, $this->twitter_secret);
        $search = eden('twitter')->search($this->twitter_key, $this->twitter_secret, $this->access_token, $this->access_secret);
        $twits = $search->search($twitter_account);
        //$twits = $this->twitter->findTwitts($twitter_account);

        $collection = Array();
        foreach($twits['statuses'] as $data) {  

            $d = new DateTime($data['created_at']);
            $node = new FeedbackNode;

            $node->id             = $data['user']['id_str'];
            $node->firstname      = $data['user']['name'];
            $node->avatar         = $data['user']['profile_image_url_https'];
            $node->text           = $data['text'];
            $node->twit_date      = $data['created_at'];
            $node->feed_type      = 'twitter';
            $node->daysago        = Helpers::relative_time($d->getTimestamp());
            $node->date           = $d->format("Y-m-d H:i:s");
            $node->head_date      = $d->format("d.m.Y");
            $node->unix_timestamp = $d->getTimestamp();
            $node->datetimeobj    = $d; 
            $collection[] = $node;
        }

        $obj = new StdClass;
        $obj->result = $collection;

        return $obj;

        /*
        $groupies = $this->underscore->groupBy($collection, 'head_date');            

        $final_collection = Array();
        foreach($groupies as $date => $children) { 

            $p = new StdClass;
            $p->date = $date;
            $p->children = Array();

            foreach($children as $child) {
                $p->daysago = Helpers::relative_time($child['unix_timestamp']);
                $p->unix_timestamp = $child['unix_timestamp'];
                $node = new FeedbackNode;
                $node->id             = $child['id'];
                $node->firstname      = $child['firstname'];
                $node->avatar         = $child['avatar'];
                $node->text           = $child['text'];
                $node->twit_date      = $child['twit_date'];
                $node->date           = $child['date'];
                $node->unix_timestamp = $child['unix_timestamp']; 
                $p->children[] = $node;
            }                
            $final_collection[] = $p;
        }

        return $final_collection;
        */
    }
}
