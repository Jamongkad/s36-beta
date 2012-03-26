<?php namespace Widget\Entities;

use \Widget\Entities\Types\WidgetDataTypes;
//use Input, Helpers;

class FormWidget extends WidgetDataTypes {
    
    public function data() { 
        return (object) Array(
            'widgetkey'   => Input::get('submit_widgetkey')
          , 'widget_type' => "submit"
          , 'site_id'     => Input::get('site_id')
          , 'company_id' => Input::get('company_id')
          , 'theme_type' => Input::get('theme_type')
          , 'theme_name' => Input::get('theme_name')
          , 'embed_type' => "form"
          , 'submit_form_text'     => Input::get('submit_form_text')
          , 'submit_form_question' => Input::get('submit_form_question')
          , 'tab_pos'  => Helpers::tab_position(Input::get('tab_type'))
          , 'tab_type' => (Input::get('tab_type')) ? Input::get('tab_type') : 'tab-l-aglow'
          , 'site_nm'  => $this->site_nm->domain
        );
    }
}
