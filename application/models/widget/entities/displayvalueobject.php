<?php namespace Widget\Entities;

use Input;
use \Widget\Entities\Types\WidgetValueObject;
use Permission;

class DisplayValueObject extends WidgetValueObject { 

    public $widget_type = 'display'; 

    public function data() {
        
        $theme_type = $this->derive_theme_type();
        $perms = $this->derive_perms();
    
        return (object) Array( 
            'widgetkey'   => $this->input_data['display_widgetkey']
          , 'widget_type' => $this->widget_type
          , 'site_id'    => $this->input_data['site_id']
          , 'company_id' => $this->input_data['company_id']
          , 'theme_type' => $theme_type
          , 'theme_name' => $this->input_data['theme_name']
          , 'form_text'  => $this->input_data['form_text']
          , 'embed_type' => $this->input_data['embed_type']
          , 'embed_block_type' => $this->input_data['embed_block_type']
          , 'embed_effects'    => $this->input_data['embed_effects']
          , 'modal_effects'    => $this->input_data['modal_effects']
          , 'perms'   => $perms 
        );
    }

    public function derive_theme_type() {    
        $theme_type = explode('-', $this->input_data['theme_type']);
        return $theme_type[1];
    }

    public function derive_perms() {
        $perm_factory = new Permission($this->input_data['perms']);
        return $perm_factory->cherry_pick('feedbacksetupdisplay');         
    }
}
