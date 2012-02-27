<?php
//TODO: You can do a better job at this. 
//Place these in a data structure of some sort
//All relevant information should be accessible via json or php
//Plugin factors such as height, frameurl, etc into data structure
//will clear up view templates from unneccesary cruft
class WidgetLoader {

    public function __construct($widget_id) {
        $this->dbw = new DBWidget;
        $this->widget_obj = $this->dbw->fetch_widget_by_id($widget_id); 
    }

    public function load() {

        $obj = $this->widget_obj;
        $wf = new WidgetFactory;

        if($obj->widget_type == 'display') {

            $params = Array(
                'company_id'   => $obj->company_id
              , 'site_id'      => $obj->site_id
              , 'is_published' => 1
              , 'is_featured'  => 1
            );

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

            $option = new StdClass;
            $option->form_text  = $obj->form_text;
            $option->children   = $obj->children;
            $option->theme_type = $obj->theme_type;
            $option->widget = $obj->embed_type;
            $option->widgetkey = $obj->widgetkey;
            $option->embed_block_type = property_exists($obj, 'embed_block_type') ? $obj->embed_block_type : null;
            $option->fixed_data = $fixed_data;
            $option->total_rows = $data->total_rows;

            return $wf->load_widget($option); 
        }

        if($obj->widget_type == 'submit') {
            $option = new StdClass;
            $option->site_id    = $obj->site_id;
            $option->company_id = $obj->company_id;
            $option->form_text  = $obj->submit_form_text;
            $option->form_question = $obj->submit_form_question;
            $option->theme_type = $obj->theme_type;
            $option->widget = $obj->embed_type;
            $option->widgetkey = $obj->widgetkey;
            $option->tab_type = $obj->tab_type;
            $option->tab_pos  = $obj->tab_pos;
            return $wf->load_widget($option);
        }
    }

    public function load_widget_js_code() {
        $deploy_env = Config::get('application.deploy_env');
        $widgetkey = "'".$this->widget_obj->widgetobj->widgetkey."'";
        $frame_url = str_replace("http://", '', $deploy_env)."/widget/js_output?widgetId=\"+widgetId+\"";  
        //$frame_url = str_replace("http://", '', $deploy_env)."/widget/js_output/\"+widgetId+\""; 
        $html = '
            <script type="text/javascript">
                var widgetId = '.$widgetkey.';
                var host = (("https:" == document.location.protocol) ? "https://secure." : "http://");
                document.write(unescape("%3Cscript src=\'" + host + "'.$frame_url.'\' type=\'text/javascript\'%3E%3C/script%3E"));
            </script>
        ';

        return trim($html);
    }

    public function load_iframe_code() {
        $widgetkey = $this->widget_obj->widgetobj->widgetkey;
        $frame_url = Config::get('application.deploy_env').'/widget/widget_loader/'.$widgetkey;
        if($this->widget_obj->widgettype == 'display') 
            return Helpers::render_iframe_code($frame_url, $this->widget_obj->width, $this->widget_obj->height);
    }    
}

class ClientRender {
    public function __construct(WidgetTypes $widget_type_obj) {
        $this->widget_type_obj    = $widget_type_obj; 
        $this->widget_loader_url  = Config::get('application.deploy_env')."/widget/widget_loader/";
        $this->form_loader_script = trim(HTML::script('js/s36_client_script.js'));
        $this->form_loader_css    = trim(HTML::style('css/s36_client_style.css'));
        $this->tab_position_css_output = trim(HTML::style(Config::get('application.deploy_env')."/widget/tab_position"));
    }  

    public function js_output() {
        $obj = $this->widget_type_obj;
        if($obj instanceof FormWidgets) {
            $data = Array(
                'js_load' => $this->form_loader_script 
              , 'css_load' => $this->form_loader_css
              , 'tab_pos' => $obj->get_tab_pos()
              , 'tab_type' => $obj->get_tab_type()
              , 'widget_loader_url' => $this->_widget_loader($obj->widgetkey)
              , 'tab_position_css' => $this->tab_position_css_output
            );
            return View::make('widget::widget_js_output_form', $data);
        }

        if($obj instanceof DisplayWidgets) {
            $data = Array(
                'js_load' => $this->form_loader_script 
              , 'css_load' => $this->form_loader_css
              , 'widget_loader_url' => $this->_widget_loader($obj->widgetkey)
              , 'widget_child_loader_url' => $this->_widget_loader($obj->get_child())
              , 'height' => $obj->get_height()
              , 'width' => $obj->get_width()
              , 'embed_block_type' => $obj->get_embed_block_type()
            );

            return View::make('widget::widget_js_output_display', $data)->get(); 
        }
    }

    private function _widget_loader($widget_key) {
        return trim($this->widget_loader_url.$widget_key);
    }
}
