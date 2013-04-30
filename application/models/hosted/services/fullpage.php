<?php namespace Hosted\Services;

use Input, Exception, StdClass, View, Helpers, Config, DB;
use Hosted\Repositories\DBHostedSettings;

class Fullpage {

    public $pattern_dir;
    public $uploaded_background_dir;
    private $hosted_settings;
    private $patterns = array(
        '45degreee_fabric.png',
        '60degree_gray.png',
        'always_grey.png',
        'batthern.png',
        'beige_paper.png'
    );
    

    public function __construct() {
        $this->hosted_settings = new DBHostedSettings;  
        $this->pattern_dir = \Config::get('application.fullpage_pattern_dir');
        $this->uploaded_background_dir = \Config::get('application.hosted_background');
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
        $background_image = null;  /* we need a default value for $background_image for newly created accounts. */
        $hs = $this->hosted_settings->get_panel_settings($company_id);
        /*for background image [uploaded or pattern]*/
        if($hs->active_background=='image') $background_image = $this->uploaded_background_dir . '/' . $hs->background_image; 
        if($hs->active_background=='pattern') $background_image = $this->pattern_dir . '/' . $hs->background_pattern; 

        $css = '<style type"text/css">';
        $css .= ( $background_image ? 'body{background-image:url("' .$background_image. '"); }' : '' );
        $css .= ( $background_image ? 'body{background-position:'.$hs->page_bg_position.'; }' : '' );
        $css .= ( $background_image ? 'body{background-repeat:'.$hs->page_bg_repeat.'; }' : '' );

        
        if( in_array($hs->background_image, $this->patterns) ){
            $css .= ( $hs->page_bg_color ? ' #bodyColorOverlay{ background: ' . $hs->page_bg_color . '; opacity: ' . $hs->page_bg_color_opacity . '}' : '' );
        }
        
        $css .= ( ! $hs->show_rating ? '.stars, .star_rating{display:none}' : '' );
        $css .= ( ! $hs->show_votes ? '.rating-stat{display:none}.vote-action{display:none}' : '' );
        $css .= ( ! $hs->show_recommendation ? '.green-thumb{display:none}' : '' );
        $css .= ( ! $hs->show_metadata ? '.custom-meta-data{display:none}' : '' );
        $css .= ( ! $hs->show_admin_comment ? '.admin-comment-block{display:none}' : '' );
        $css .= ( ! $hs->show_sharing_option ? '.share-button{display:none}' : '' );
        $css .= ( ! $hs->show_flag_inapp ? ' .flag_control{ display: none; }' : '' );
        $css .= ( ! $hs->show_avatar ? '.author-avatar{display:none}.author-information{margin-left:0px;}' : '' );
        $css .= ( ! $hs->show_last_name_as_ini ? ' .last_name_ini{ display : none; } .last_name{ display: inline-block; }' : ' .last_name_ini{ display : inline-block; } .last_name{ display: none; } ' );
        $css .= ( ! $hs->show_position ? ' .job{ display : none } ' : '' );
        $css .= ( ! $hs->show_company ? ' .company{ display : none } .company_comma{ display : none }' : '' );
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
