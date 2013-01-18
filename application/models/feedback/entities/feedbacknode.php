<?php namespace Feedback\Entities;

use StdClass;
use Helpers;

class FeedbackNode {

    private $data;

    public function __construct($data) {
        $this->data = $data;     
    }

    public function generate() {
        $node = new StdClass; 
        foreach($this->data as $key => $value) {
            if($key) { 
                $node->$key = $value;
                if($key == 'metadata' || $key == 'attachments') {
                    $node->$key = json_decode($value);
                }
            } 
        }

        Helpers::dump($node);

        return $node;
        /*
        $node->id          = $data->id;      
        $node->firstname   = $data->firstname;
        $node->lastname    = $data->lastname;
        $node->logintype   = $data->logintype;
        $node->countryname = $data->countryname;
        $node->countrycode = $data->countrycode;
        $node->profilelink = $data->profilelink;
        $node->date        = $data->date;
        $node->head_date_format = $data->head_date_format;
        $node->status      = $data->status;
        $node->text        = $data->text;
        $node->attachments = $data->attachments;
        $node->categoryid  = $data->categoryid;  
        $node->category    = $data->category;  
        $node->priority    = $data->priority;  
        $node->rating      = $data->rating;
        $node->ispublished = $data->ispublished;
        $node->isdeleted   = $data->isdeleted;
        $node->isfeatured  = $data->isfeatured;
        $node->permission_css = $data->permission_css;
        $node->permission = $data->permission;
        $node->contactid  = $data->contactid;
        $node->siteid     = $data->siteid;
        $node->perm_val   = $data->perm_val;
        $node->email      = $data->email;
        $node->unix_timestamp = $data->unix_timestamp;
        $node->daysago    = $data->daysago;
        $node->sitedomain = $data->sitedomain;
        $node->avatar     = $data->avatar;
        $node->origin     = $data->origin;
        $node->socialid   = $data->socialid;
        
        $node->admin_reply    = $data->admin_reply;
        $node->admin_userid   = $data->admin_userid;
        $node->admin_username = $data->admin_username;
        $node->admin_fullname = $data->admin_fullname;
        $node->admin_email    = $data->admin_email;
        $node->admin_companyname = $data->admin_companyname;
        $node->admin_fullpagecompanyname = $data->admin_fullpagecompanyname;

        if( property_exists($data, 'attachments') ) $node->attachments = json_encode($node->attachments);
        if( property_exists($data, 'metadata') ) $node->metadata = json_encode($node->metadata);
        if( property_exists($data, 'flagged') ) $node->flagged = $data->flagged;
        if( property_exists($data, 'useful') ) $node->useful = $data->useful;
        if( property_exists($data, 'vote_count') ) $node->vote_count = $data->vote_count;
        
        /*
        $attachments = Null;
        if(!empty($data->attachments)) {
            $attachments = json_decode($data->attachments);
        }

        $metadata = Null;
        if(!empty($data->metadata)) {
            $metadata = json_decode($data->metadata);
        }

        $node->attachments = $attachments;
        $node->metadata    = $metadata;
        */ 
        //return $node;

    }

    
    /*
    public function __get($name) {
        if(array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): '  . $name .
            ' in ' . $trace[0]['file'] . 
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );
        return null;
    }
    */
}
