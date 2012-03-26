<?php namespace Widget\Services;

use DB, Input, Helpers;
use Widget\Repositories\DBWidget;
use Widget\Entities\DisplayWidget;
use Widget\Entities\FormWidget;

class WidgetDataManager {
    /*
    public function __construct() {
        $this->site_nm = DB::Table('Site')->where('siteId', '=', Input::get('site_id'))->first(Array('domain'));
    }
    */
    
    //TODO: UGLEEEEEEEEEEEEEEEEEEEEEEEE
    public function create_and_save_widget() {  
        $form = new FormWidget;
        $form->save();
        
        $emit_data = Array(
            'submit' => $form->emit()
        );

        echo json_encode($emit_data); 
        /*
        $display_data = $this->provide_data_for('display');
        $submit_data  = $this->provide_data_for('submit');

        if ( Input::get('widget_type') == 'display' ) {  

            $display = new DisplayWidget($display_data);
            $form = new FormWidget($submit_data);
            
            if($display_data->widgetkey && $submit_data->widgetkey) { 
                $display->update();
                $form->update();
            } else { 
                $display->save();
                $form->save();
                $display->adopt($form);
            }
            
            $emit_data = Array(
                'display' => $display->emit()
              , 'submit'  => $form->emit()
            );

            echo json_encode($emit_data);
        }

        if ( Input::get('widget_type') == 'submit' ) {  
            
            $form = new FormWidget($submit_data);
            if($submit_data->widgetkey) { 
                $form->update();
            } else { 
                $form->save();
            }
            
            $emit_data = Array(
                'submit' => $form->emit()
            );

            echo json_encode($emit_data); 
        }
        */
    }
    /*
    public function provide_data_for($force_type=False) {
        if ( $force_type == "display" ) {

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

        if ( $force_type == "submit" ) {

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
    */
}
