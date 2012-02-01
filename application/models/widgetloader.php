<?php

class WidgetLoader {

    public function __construct($widget_id) {
        $this->widget_id = $widget_id;
    }

    public function execute() {

        $dbw = new DBWidget;
        $widget_obj = $dbw->fetch_widget_by_id($this->widget_id); 
        $obj = base64_decode($widget_obj->widgetobjstring);
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
}

class WidgetDelivery {
    public $widget_data, $widget_view;
}
