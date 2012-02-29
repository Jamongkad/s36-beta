<?php

class WidgetDataManager {
    public function __construct() {
        $this->site_nm = DB::Table('Site')->where('siteId', '=', Input::get('site_id'))->first(Array('domain'));
    }

    public function create_and_save_widget() {  
        if ( Input::get('widget_type') == 'display' ) {  
            $display_data = $this->provide_data_for('display');
            $submit_data  = $this->provide_data_for('submit');

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
            $submit_data  = $this->provide_data_for('submit');
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
    }

    public function provide_data_for($force_type=False) {
        if ( $force_type == "display" ) {

            $perm_factory = new Permission(Input::get('perms'));
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

            $tab_pos = null;
            $match = null;  
            if ( preg_match('~tab-(br|bl|tr|tl)~', Input::get('tab_type'), $match) ) {
                $tab_pos = 'corner';
            } else {
                //if not then assume side tab
                $tab_pos = 'side';
            } 

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
              , 'tab_pos'  => $tab_pos
              , 'tab_type' => Input::get('tab_type')
              , 'site_nm'  => $this->site_nm->domain
            );
            
        }
    }
}

abstract class WidgetDataTypes {

    private $_data, $_dbw, $_id;

    public function __construct($data) {
        $this->_data = $data;     
        $this->_dbw = new DBWidget; 
    }

    public function save() { 
        $insert_id = $this->_dbw->save_widget($this->_data);
        $this->_dbw->insert_ancestor($insert_id, $insert_id);
        $this->_id = $insert_id; 
    }

    public function update() {
        $this->_dbw->update_widget_by_id($this->_data->widgetkey, $this->_data);
        $obj = $this->_dbw->fetch_widget_by_id($this->_data->widgetkey);
        $this->_id = $obj->widgetstoreid;
    }

    public function delete() {}
    public function adopt(WidgetDataTypes $child) { 
        //add this child set path length to one
        $this->_dbw->insert_ancestor($this->_id, $child->get_widget_id(), 1);
    }
    public function get_widget_id() {
        return $this->_id;     
    }

    public function emit() { 
        $obj = $this->_dbw->fetch_widget_by_id($this->_id);
        return Array('widget_type' => 'display', 'widget' => $obj);
    }
}

class DisplayWidget extends WidgetDataTypes {
}

class FormWidget extends WidgetDataTypes { 
}
