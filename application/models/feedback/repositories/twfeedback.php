<?php namespace Feedback\Repositories;

use Underscore\Underscore;
use \Twitter\Twitter;
use \Feedback\Entities\FeedbackNode;
use DateTime, StdClass, Helpers;

class TWFeedback {
    public function __construct() { 
        $this->twitter = new Twitter;
        $this->underscore = new Underscore;
    }

    public function pull_twits_for($twitter_account) {
        
        $twits = $this->twitter->findTwitts($twitter_account);

        $collection = Array();
        foreach($twits as $data) {  
            /*
            $snode = Array(); 
            $d = new DateTime($data->created_at);

            $snode['id'] = $data->id_str;
            $snode['firstname'] = $data->from_user;
            $snode['avatar'] = $data->profile_image_url_https;
            $snode['text'] = $data->text;
            $snode['twit_date'] = $data->created_at;
            $snode['date'] = $d->format("Y-m-d H:i:s");
            $snode['head_date'] = $d->format("d.m.Y");
            $snode['unix_timestamp'] = $d->getTimestamp();
            $collection[] = $snode;
            */
            $d = new DateTime($data->created_at);
            $node = new FeedbackNode;

            $node->id             = $data->id_str;
            $node->firstname      = $data->from_user;
            $node->avatar         = $data->profile_image_url_https;
            $node->text           = $data->text;
            $node->twit_date      = $data->created_at;
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
