<?php

class WidgetLoader {

    public function __construct($widget_id) {
        $this->dbw = new DBWidget;
        $this->widget_obj = $this->dbw->fetch_widget_by_id($widget_id); 
    }

    public function render() {

        $obj = $this->_load_object_code();

        $params = Array(
            'company_id'   => $obj->company_id
          , 'site_id'      => $obj->site_id
          , 'is_published' => 1
          , 'is_featured'  => 1
        );

        $feedback = new DBFeedback;       
        $data = $feedback->pull_feedback_by_company($params);
        $data->block_display = $obj->perms;

        $widget_view = null;
        if ($obj->embed_type == 'embedded') {
         
            if ($obj->embed_block_type == 'embed_block_x') {
                $widget_view = 'widget::widget_embedded_hor_view';
            }

            if ($obj->embed_block_type == 'embed_block_y') { 
                $widget_view = 'widget::widget_embedded_ver_view';
            }
              
        } 
        
        if ($obj->embed_type == 'modal') {
            $widget_view = "widget::widget_modal_popup_view";
        }

        $fixed_data = Array();
        foreach ($data->result as $rows) {
           //check if feedback is locked individually
           if ($rows->indlock == 1) { 
               $feed_rules = $obj->perms;    
           } else {
               $feed_rules = new StdClass;
               $feed_rules->displayname     = $rows->displayname;
               $feed_rules->displayimg      = $rows->displayimg;
               $feed_rules->displaycompany  = $rows->displaycompany;
               $feed_rules->displayposition = $rows->displayposition;
               $feed_rules->displayurl      = $rows->displayurl;
               $feed_rules->displaycountry  = $rows->displaycountry;
               $feed_rules->displaysbmtdate = $rows->displaysbmtdate;
           }

           $rows->rules = (object)$feed_rules;
           $fixed_data[] = $rows;
        }

        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'result' => $fixed_data, 'row_count' => $data->total_rows
        ));
    }

    public function deploy_client_code() {

        $obj = $this->_load_object_code();

        if ($obj->embed_type == 'embedded') {  
            if($obj->embed_block_type == 'embed_block_x') {
                $widget_ht = 300;
            }

            if($obj->embed_block_type == 'embed_block_y') { 
                $widget_ht = 700; 
            }     
        } 

        if ($obj->embed_type == 'modal') {
            $widget_ht = 500;
        }
        
        $data = Array(
            'deploy_url' => Config::get('application.deploy_env')
          , 'widget_height' => $widget_ht
        );
        
        return $data;
    }

    private function _load_object_code() {      
        $obj = base64_decode($this->widget_obj->widgetobjstring);
        $obj = unserialize($obj); 
        return $obj;
    }
}
