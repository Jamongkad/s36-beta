<?php

class WidgetLoader {

    public function __construct($widget_id) {
        $this->dbw = new DBWidget;
        $this->widget_id = $widget_id;
        $this->widget_obj = $this->dbw->fetch_widget_by_id($widget_id); 
    }

    public function render($type="view") {

        $obj = $this->_load_object_code();

        $params = Array(
            'company_id'   => $obj->company_id
          , 'site_id'      => $obj->site_id
          , 'is_published' => 1
          , 'is_featured'  => 1
        );

        if($obj->widget_type == 'display') {
            $feedback = new DBFeedback;       
            $data = $feedback->pull_feedback_by_company($params);

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
             
            if ($type == 'view') { 
                $option = new StdClass;
                $option->form_text  = $obj->form_text;
                $option->theme_type = $obj->theme_type;
                $option->widget = $obj;
                $option->fixed_data = $fixed_data;
                $option->total_rows = $data->total_rows;

                $wf = new WidgetFactory($option); 
                return $wf->load_widget()->render();
            }
 
        }

        if($obj->widget_type == 'submit') {
             if ($type == 'view') {
                $option = new StdClass;
                $option->site_id    = $obj->site_id;
                $option->company_id = $obj->company_id;
                $option->form_text  = $obj->form_text;
                $option->theme_type = $obj->theme_type;
                $option->widget = $obj->embed_type;
                $wf = new WidgetFactory($option);
                return $wf->load_widget()->render();
            }
        }
    }

    public function load_widget_js_code() {
        $frame_url = str_replace("http://", '', Config::get('application.deploy_env'))."/widget/js_output?widgetId=\"+widgetId+\""; 
        $widgetkey = "'".$this->widget_obj->widgetkey."'";
        $html = '
            <script type="text/javascript">
                var widgetId = '.$widgetkey.';
                var host = (("https:" == document.location.protocol) ? "https://secure." : "http://");
                document.write(unescape("%3Cscript src=\'" + host + "'.$frame_url.'\' type=\'text/javascript\'%3E%3C/script%3E"));
                var widget = new WidgetLoader({
                    "widgetId": widgetId
                });
                widget.display();
            </script>
        ';
        return trim($html);
    }

    public function load_iframe_code() {
        $widgetkey = $this->widget_obj->widgetkey;
        $frame_url = Config::get('application.deploy_env').'/widget/widget_loader/'.$widgetkey;
        /*
        $iframe = "<span style='z-index:100001'>
                    <iframe id='s36Widget' 
                            allowTransparency='true' 
                            height={$this->widget_obj->height}
                            width={$this->widget_obj->width}
                            frameborder='0' 
                            scrolling='no' 
                            src='$frame_url'>Your Widget</iframe>
                    </span>";
         return trim($iframe);
         */
         return Helpers::render_iframe_code($frame_url, $this->widget_obj->width, $this->widget_obj->height);
    }

    private function _load_object_code() {      
        $obj = base64_decode($this->widget_obj->widgetobjstring);
        $obj = unserialize($obj); 
        return $obj;
    }
}
