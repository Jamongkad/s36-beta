<?php namespace Widget\Entities;

use \Widget\Entities\Types\WidgetDataTypes;
use Input, Helpers;

class DisplayWidget extends WidgetDataTypes {
    /* 
    public function data() {
        $perm_factory = new \Permission(Input::get('perms'));
        $perms = $perm_factory->cherry_pick('feedbacksetupdisplay');        

        $theme_type = explode('-', Input::get('theme_type'));
        $theme_type = $theme_type[1];

        return (object) Array(
            'widgetkey'   => Input::get('display_widgetkey')
          , 'widget_type' => "display"
          , 'site_id'    => Input::get('site_id')
          , 'company_id' => Input::get('company_id')
          , 'theme_type' => $theme_type
          , 'theme_name' => Input::get('theme_name')
          , 'form_text'  => Input::get('form_text')
          , 'embed_type' => Input::get('embed_type')
          , 'embed_block_type' => Input::get('embed_block_type')
          , 'embed_effects'    => Input::get('embed_effects')
          , 'modal_effects'    => Input::get('modal_effects')
          , 'perms'   => $perms 
          , 'site_nm' => $this->site_nm->domain
        );
    }
    */
}
