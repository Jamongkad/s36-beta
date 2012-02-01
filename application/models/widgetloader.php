<?php

class WidgetLoader {

    public function __construct($widget_id) {

        $this->dbw = new DBWidget;
        $this->widget_obj = $this->dbw->fetch_widget_by_id($widget_id); 

    }

    public function render() {

        $dbw = new DBWidget;
        $obj = base64_decode($this->widget_obj->widgetobjstring);
        $obj = unserialize($obj); 

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

        $wd = new WidgetDelivery;         
        $wd->widget_view = $widget_view;
        $wd->widget_data = $fixed_data;
        $wd->widget_obj  = $obj;
        $wd->total_rows  = $data->total_rows;
        $fixed_data = null;
        return $wd;
    }

    public function deploy_client_code() {
        $obj = base64_decode($this->widget_obj->widgetobjstring);
        $obj = unserialize($obj); 

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
}

class WidgetDelivery {
    public $widget_data, $widget_view;
}
