<?php

class WidgetFactory {

   public function load_widget($option) {
       if ($option->widget == 'form') {
           $widget = new SubmissionWidget($option);     
           return $widget;
       }

       if ($option->widget == 'embedded') {
           if ($option->embed_block_type == 'embed_block_x') {
               $widget = new HorizontalEmbedWidget($option);
               return $widget;
           }

           if ($option->embed_block_type == 'embed_block_y') { 
               $widget = new VerticalEmbedWidget($option);
               return $widget;
           }
       }

       if ($option->widget == 'modal') {    
           $widget = new ModalEmbedWidget($option);
           return $widget;
       }
   }
}

abstract class WidgetTypes {

    protected $height;
    protected $width;
    protected $css;
    protected $js;

    public function render_data() {}
    public function get_height() {
        return $this->height;      
    }
    public function get_width() { 
        return $this->width;      
    }
}

class DisplayWidgets extends WidgetTypes { 
    public function get_embed_block_type() {
        return $this->embed_block_type; 
    }

    public function get_child() {
        $child_key = null;
        if($this->children) {
            foreach($this->children as $child) { 
                $child_key = $child->widgetkey; 
            }
        }
        return $child_key;
    }
}

class FormWidgets extends WidgetTypes { 
    public function get_tab_type() {}
    public function get_tab_pos() {}
}

class SubmissionWidget extends FormWidgets {

    protected $height = 590;
    protected $width = 447;
    
    public function __construct($options) {

        $this->env = Config::get('application.env_name');
        if($this->env == 'dev' or $this->env == 'local') { 
            $this->fb_id = '171323469605899';
            $fb_secret   = 'b60766ccb12c32c92029a773f7716be8';
        }

        if($this->env == 'prod') { 
            $this->fb_id = '259670914062599';
            $fb_secret   = '8e0666032461a99fb538e5f38ac7ef93';
        }
        
        $this->widgetkey  = $options->widgetkey;
        $this->site_id    = $options->site_id;
        $this->company_id = $options->company_id;
        $this->form_text  = $options->submit_form_text;
        $this->form_question = $options->submit_form_question;
        $this->theme_type = $options->theme_type;
        $this->tab_pos  = $options->tab_pos;
        $this->tab_type = $options->tab_type;
    }

    public function render_data() {
        $widget_view = 'widget::widget_submissionform_view';
        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'fb_app_id' => $this->fb_id  
          , 'env' => $this->env
          , 'country' => DB::Table('Country', 'master')->get()
          , 'site_id' => $this->site_id
          , 'company_id' => $this->company_id
          , 'form_text' => $this->form_text
          , 'form_question' => $this->form_question
          , 'theme_name' => $this->theme_type
          , 'response' => 0
        ))->get();  
    }

    public function get_tab_type() { 
        return $this->tab_type;
    }

    public function get_tab_pos() { 
        return $this->tab_pos;
    }
}

class VerticalEmbedWidget extends DisplayWidgets {

    protected $width = 250;
    protected $height = 500;

    public function __construct($options) { 
        $this->widgetkey  = $options->widgetkey;
        $this->form_text  = $options->form_text;
        $this->fixed_data = $options->fixed_data;
        $this->total_rows = $options->total_rows;
        $this->embed_block_type = $options->embed_block_type;
        $this->children  = $options->children;
        $this->css  = HTML::style('themes/widget/'.$options->theme_type.'/css/'.$options->theme_type.'_vertical_style.css');
        $this->css .= HTML::style('css/widget_master/ie_fix.css');
        $this->js = HTML::script('js/widget/vertical.js');
    }

    public function render_data() { 
        $widget_view = 'widget::widget_embedded_ver_view';
        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'result' => $this->fixed_data, 'row_count' => $this->total_rows, 'flavor_text' => $this->form_text, 'css' => $this->css, 'js' => $this->js
        ))->get();
    }

}

class HorizontalEmbedWidget extends DisplayWidgets {

    protected $width = 780;
    protected $height = 320;

    public function __construct($options) {
        $this->widgetkey  = $options->widgetkey;
        $this->form_text  = $options->form_text;
        $this->fixed_data = $options->fixed_data;
        $this->total_rows = $options->total_rows;
        $this->embed_block_type = $options->embed_block_type;
        $this->children  = $options->children;
        $this->css  = HTML::style('themes/widget/'.$options->theme_type.'/css/'.$options->theme_type.'_horizontal_style.css');
        //$this->css .= HTML::style('css/widget_master/ie_fix.css');
        $this->js = HTML::script('js/widget/horizontal.js'); 
    }

    public function render_data() { 
        $widget_view = 'widget::widget_embedded_hor_view';
        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'result' => $this->fixed_data, 'row_count' => $this->total_rows, 'flavor_text' => $this->form_text, 'css' => $this->css, 'js' => $this->js
        ))->get();
    }
}

class ModalEmbedWidget extends DisplayWidgets {

    protected $width = 760;
    protected $height = 500;

    public function __construct($options) {
        $this->widgetkey  = $options->widgetkey;
        $this->form_text  = $options->form_text;
        $this->fixed_data = $options->fixed_data;
        $this->total_rows = $options->total_rows;
        $this->embed_block_type = $options->embed_block_type;
        $this->children  = $options->children;
        $this->css  = HTML::style('themes/widget/'.$options->theme_type.'/css/'.$options->theme_type.'_popup_style.css');
        $this->css .= HTML::style('css/widget_master/ie_fix.css');
        $this->js = HTML::script('js/widget/popup.js');  
    } 

    public function render_data() {
        $widget_view = 'widget::widget_modal_popup_view';
        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'result' => $this->fixed_data, 'row_count' => $this->total_rows, 'flavor_text' => $this->form_text, 'css' => $this->css, 'js' => $this->js
        ))->get();
    }
}
