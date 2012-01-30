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
         
            if($obj->embed_block_type == 'embed_block_x') {
                $widget_view = 'widget::widget_embedded_hor_view';
            }

            if($obj->embed_block_type == 'embed_block_y') { 
                $widget_view = 'widget::widget_embedded_ver_view';
            }
              
        } 
        
        if ($obj->embed_type == 'modal') {
            $widget_view = "widget::widget_modal_popup_view";
        }

        $wd = new WidgetDelivery;         
        $wd->data = $data;
        $wd->widget_view = $widget_view;
        return $wd;
    }
}

class WidgetDelivery {
    public $data, $widget_view;
}
