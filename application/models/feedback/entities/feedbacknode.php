<?php namespace Feedback\Entities;

use StdClass;
use Helpers;

class FeedbackNode {

    private $data;
    private $additional_data;

    public function __construct($data) {
        $this->data = $data;     
    }

    public function set_additional_data($data) {
        $this->additional_data = $data; 
    }

    public function generate() {
          
        $node = new StdClass; 
        $node->id = $this->data->id;
        $node->intname = $this->data->intname;
        $node->category = $this->data->category;
        $node->category = $this->data->category;
        $node->status = $this->data->status;
        $node->priority = $this->data->priority;
        $node->title = $this->data->title;
        $node->text = $this->data->text;
        $node->date = $this->data->date;
        $node->head_date_format = $this->data->head_date_format;
        $node->daysago = $this->data->daysago;
        $node->unix_timestamp = $this->data->unix_timestamp;
        $node->permission = $this->data->permission;
        $node->rating = $this->data->rating;
        $node->int_rating = $this->data->int_rating;
        $node->permission_css = $this->data->permission_css;
        $node->perm_val = $this->data->perm_val;
        $node->isfeatured = $this->data->isfeatured;
        $node->isflagged = $this->data->isflagged;
        $node->ispublished = $this->data->ispublished;
        $node->isrecommended = $this->data->isrecommended;
        $node->isarchived = $this->data->isarchived;
        $node->issticked = $this->data->issticked;
        $node->isdeleted = $this->data->isdeleted;
        $node->displayname = $this->data->displayname;
        $node->displayimg = $this->data->displayimg;
        $node->displaycompany = $this->data->displaycompany;
        $node->displayposition = $this->data->displayposition;
        $node->displayurl = $this->data->displayurl;
        $node->displaycountry = $this->data->displaycountry;
        $node->displaysbmtdate = $this->data->displaysbmtdate;
        $node->indlock = $this->data->indlock;
        $node->attachments = json_decode($this->data->attachments);
        $node->metadata = json_decode($this->data->metadata);
        $node->adminreply = $this->data->adminreply;
        $node->contactid = $this->data->contactid;
        $node->firstname = $this->data->firstname;
        $node->lastname = $this->data->lastname;
        $node->email = $this->data->email;
        $node->profilelink = $this->data->profilelink;
        $node->position = $this->data->position;
        $node->url = $this->data->url;
        $node->city = $this->data->city;
        $node->companyname = $this->data->companyname;
        $node->avatar = $this->data->avatar;
        $node->logintype = $this->data->logintype;
        $node->ipaddress = $this->data->ipaddress;
        $node->browser = $this->data->browser;
        $node->countryname = $this->data->countryname;
        $node->countrycode = $this->data->countrycode;
        $node->avatar = $this->data->avatar;
        $node->siteid = $this->data->siteid;
        $node->sitedomain = $this->data->sitedomain;
        $node->origin = $this->data->origin;
        $node->socialid = $this->data->socialid;
        $node->word_count = property_exists($this->data, 'word_count') ? $this->data->word_count: null;
        $node->vote_count = property_exists($this->data, 'vote_count') ? $this->data->vote_count: null;
        $node->useful = property_exists($this->data, 'useful') ? $this->data->useful: null;
        $node->flagged_as_inappr = property_exists($this->data, 'flagged_as_inappr') ? $this->data->flagged_as_inappr: null;
        $node->admin_userid = property_exists($this->data, 'admin_userid') ? $this->data->admin_userid: null;
        $node->admin_reply = property_exists($this->data, 'admin_reply') ? $this->data->admin_reply: null;
        $node->admin_username = property_exists($this->data, 'admin_username') ? $this->data->admin_username: null;
        $node->admin_fullname = property_exists($this->data, 'admin_fullname') ? $this->data->admin_fullname: null;
        $node->admin_avatar = property_exists($this->data, 'admin_avatar') ? $this->data->admin_avatar: null;
        $node->admin_email = property_exists($this->data, 'admin_email') ? $this->data->admin_email: null;
        $node->admin_companyname = property_exists($this->data, 'admin_companyname') ? $this->data->admin_companyname: null;
        $node->admin_fullpagecompanyname = property_exists($this->data, 'admin_fullpagecompanyname') ? $this->data->admin_fullpagecompanyname: null;

        if($this->additional_data) {
            $node->reports = array_key_exists($this->data->id, $this->additional_data) ? $this->additional_data[$this->data->id] : null;
        }

        return $node;
    }    
}
