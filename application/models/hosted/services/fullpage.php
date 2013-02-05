<?php namespace Hosted\Services;

use Input, Exception, StdClass, View, Helpers, Config;

class Fullpage {

  public $pattern_dir;
  public $rating_stars;
  public $useful_count;
  public $recommend;
  public $custom_field;
  public $commenting;
  public $fb_sharing;
  public $report_fb;
  public $display_first_name;
  public $display_last_name;
  public $display_job;
  public $display_company_name;
  public $display_city;
  public $display_country;
  public $display_flag;
  public $display_img_attachments;
  public $display_link_attachments;
  public $display_avatar;

 public function __construct() {
  $this->pattern_dir = \Config::get('application.fullpage_pattern_dir');

  /*
  / temporary display data
  / this will be replaced from actual data in HostedSettings table in S36 Database
  */
  $this->rating_stars             = 1;
  $this->useful_count             = 1;
  $this->recommend                = 1;
  $this->custom_field             = 1;
  $this->commenting               = 1;
  $this->fb_sharing               = 1;
  $this->report_fb                = 1;
  $this->display_first_name       = 1;
  $this->display_last_name        = 1;
  $this->display_job              = 1;
  $this->display_company_name     = 1;
  $this->display_city             = 1;
  $this->display_country          = 1;
  $this->display_flag             = 1;
  $this->display_avatar           = 1;
  $this->display_img_attachments  = 1;
  $this->display_link_attachments = 1;
 }

 public function get_fullpage_pattern(){
    $patterns = glob($this->pattern_dir.'/*.png');
    $pattern_obj = new StdClass;
    $result = array();
    $index = 0;
    foreach($patterns as $pattern){
      $result[$index]['basename'] = str_replace($this->pattern_dir.'/','',$pattern);
      $result[$index]['path'] = $pattern;
      $index+=1;
    }
    
    return (Object) $result;
  }

public function get_fullpage_css(){
    $css = '<style type="text/css">';
    if(!$this->rating_stars){
      $css .= '.stars{display:none}';
    }
    if(!$this->useful_count){
      $css .= '.rating-stat{display:none}.feedback-actions{display:none}';
    }
    if(!$this->recommend){
      $css .= '.feedback-recommendation{display:none}';
    }
    if(!$this->custom_field){
      $css .= '.custom-meta-data{display:none}';
    }
    if(!$this->commenting){
      $css .= '.admin-comment-block{display:none}';
    }
    if(!$this->fb_sharing){
      $css .= '.share-button{display:none}';
    }
    if(!$this->report_fb){
      $css .= '.flag-as{display:none}';
    }
    if(!$this->display_first_name){
      $css .= '.first_name{display:none}';
    }
    if(!$this->display_last_name){
      $css .= '.last_name{display:none}';
    }
    if(!$this->display_job){
      $css .= '.job{display:none}.company_comma{display:none}';
    }
    if(!$this->display_company_name){
      $css .= '.company{display:none}.company_comma{display:none}';
    }
    if(!$this->display_city){
      $css .= '.city{display:none}.location_comma{display:none}';
    }
    if(!$this->display_country){
      $css .= '.country{display:none}.location_comma{display:none}';
    }
    if(!$this->display_flag){
      $css .= '.flag{display:none}';
    }
    if(!$this->display_img_attachments){
      $css .= '.uploaded-images{display:none}';
    }
    if(!$this->display_link_attachments){
      $css .= '.uploaded-link{display:none}.uploaded-video{display:none}';
    }
    if(!$this->display_avatar){
      $css .= '.author-avatar{display:none}.author-information{margin-left:0px;}';
    }
    $css .= '</style>';
    return $css;
  }
}
