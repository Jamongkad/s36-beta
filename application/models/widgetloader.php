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
                $widget_view = 'widget::widget_modal_popup_view';
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
            
            if ($type == 'view') { 
                return View::of_widget_layout()->partial('contents', $widget_view, Array(
                    'result' => $fixed_data, 'row_count' => $data->total_rows, 'flavor_text' => $obj->form_text
                ))->get();
            }
            
        }

        if($obj->widget_type == 'submit') {

            if ($obj->embed_type == 'form') {
                $widget_view = 'widget::widget_submissionform_view';
            }
            //Helpers::show_data($obj);

            $env = Config::get('application.env_name');
            if($env == 'dev' or $env == 'local') { 
                $fb_id = '171323469605899';
                $fb_secret = 'b60766ccb12c32c92029a773f7716be8';
            }

            if($env == 'prod') { 
                $fb_id = '259670914062599';
                $fb_secret = '8e0666032461a99fb538e5f38ac7ef93';
            }
            
            if ($type == 'view') {
                return View::of_widget_layout()->partial('contents', $widget_view, Array(
                    'fb_app_id' => $fb_id  
                  , 'env' => $env
                  , 'country' => DB::Table('Country', 'master')->get()
                  , 'site_id' => $obj->site_id
                  , 'company_id' => $obj->company_id
                  , 'form_widget_vars'=> $obj
                  , 'response' => 1
                ))->get(); 
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
    }

    private function _load_object_code() {      
        $obj = base64_decode($this->widget_obj->widgetobjstring);
        $obj = unserialize($obj); 
        return $obj;
    }
}
