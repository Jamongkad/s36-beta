<?php namespace Hosted\Services;

use Input, Exception, StdClass, View, Helpers, Config, DB;

class Fullpage {

    public $pattern_dir;
    private $hosted_settings;
    
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
        //$this->

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
        $this->display_img_attachments  = 1;
        $this->display_link_attachments = 1;
        $this->display_avatar           = 1;
        $this->button_bg_color          = '#000';
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

    public function get_fullpage_css($company_id){
        $hs = $this->hosted_settings = Db::table('HostedSettings')->where('companyId', '=', $company_id)->first();
        
        $css = '<style type"text/css">';
        $css .= ( ! $hs->show_rating ? '.stars, .star_rating{display:none}' : '' );
        $css .= ( ! $hs->show_votes ? '.rating-stat{display:none}.feedback-actions{display:none}' : '' );
        $css .= ( ! $hs->show_recommendation ? '.feedback-recommendation{display:none}' : '' );
        $css .= ( ! $hs->show_metadata ? '.custom-meta-data{display:none}' : '' );
        $css .= ( ! $hs->show_admin_comment ? '.admin-comment-block{display:none}' : '' );
        $css .= ( ! $hs->show_sharing_option ? '.share-button{display:none}' : '' );
        $css .= ( ! $hs->show_flag_inapp ? '.flag-as{display:none}' : '' );
        $css .= ( ! $hs->show_avatar ? '.author-avatar{display:none}.author-information{margin-left:0px;}' : '' );
        $css .= ( ! $hs->show_last_name_as_ini ? '.last_name{display:none}' : '' );
        $css .= ( ! $hs->show_position ? '.job{display:none}' : '' );
        $css .= ( ! $hs->show_company ? '.company{display:none}.company_comma{display:none}' : '' );
        $css .= ( ! $hs->show_city ? '.city{display:none}' : '' );
        $css .= ( ! $hs->show_country ? '.country{display:none}.location_comma{display:none}' : '' );
        $css .= ( ! $hs->show_flag ? '.flag{display:none}' : '' );
        $css .= ( ! $hs->show_image_attachment ? '.uploaded-images{display:none}' : '' );
        $css .= ( ! $hs->show_video_attachment ? '.uploaded-link{display:none}.uploaded-video{display:none}' : '' );
        $css .= ( ! is_null($hs->button_bg_color) ? '.send-button a{ background-color: ' . $hs->button_bg_color . '; }' : '' );
        $css .= ( ! is_null($hs->button_hover_bg_color) ? '.send-button a:hover{ background-color: ' . $hs->button_hover_bg_color . '; }' : '' );
        $css .= ( ! is_null($hs->button_font_color) ? '.send-button a{ color: ' . $hs->button_font_color . '; }' : '' );
        $css .= '</style>';
        return $css;
    }
}
