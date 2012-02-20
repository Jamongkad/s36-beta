<?php

class WidgetFactory {
   public function __construct($option) {
       $this->option = $option;     
   }

   public function load_widget() {
       if ($this->option->widget == 'form') {
           $widget = new SubmissionWidget($this->option);     
           return $widget;
       }

       if ($this->option->widget->embed_type == 'embedded') {
           if ($this->option->widget->embed_block_type == 'embed_block_x') {
               $widget = new HorizontalEmbedWidget($this->option);
               return $widget;
           }

           if ($this->option->widget->embed_block_type == 'embed_block_y') { 
               $widget = new VerticalEmbedWidget($this->option);
               return $widget;
           }
       }

       if ($this->option->widget->embed_type == 'modal') {    
           $widget = new ModalEmbedWidget($this->option);
           return $widget;
       }
   }
}

abstract class WidgetTypes {
    public function render() {}
}

class SubmissionWidget extends WidgetTypes {

    public $height = 590;
    public $width = 447;
    
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

        $this->site_id    = $options->site_id;
        $this->company_id = $options->company_id;
        $this->form_text  = $options->form_text;
        $this->form_question = $options->form_question;
        $this->theme_type = $options->theme_type;
    }

    public function render() {

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
}

class VerticalEmbedWidget extends WidgetTypes {

    public $width = 250;
    public $height = 500;

    public function __construct($options) { 
        $this->form_text  = $options->form_text;
        $this->fixed_data = $options->fixed_data;
        $this->total_rows = $options->total_rows;
        $this->css  = HTML::style('themes/widget/'.$options->theme_type.'/css/'.$options->theme_type.'_vertical_style.css');
        $this->css .= HTML::style('css/widget_master/ie_fix.css');
        $this->js = HTML::script('js/widget/vertical.js');
    }

    public function render() { 
        $widget_view = 'widget::widget_embedded_ver_view';
        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'result' => $this->fixed_data, 'row_count' => $this->total_rows, 'flavor_text' => $this->form_text, 'css' => $this->css, 'js' => $this->js
        ))->get();
    }
}

class HorizontalEmbedWidget extends WidgetTypes {

    public $width = 780;
    public $height = 320;

    public function __construct($options) {
        $this->form_text  = $options->form_text;
        $this->fixed_data = $options->fixed_data;
        $this->total_rows = $options->total_rows;
        $this->css  = HTML::style('themes/widget/'.$options->theme_type.'/css/'.$options->theme_type.'_horizontal_style.css');
        $this->css .= HTML::style('css/widget_master/ie_fix.css');
        $this->js = HTML::script('js/widget/horizontal.js'); 
    }

    public function render() { 
        $widget_view = 'widget::widget_embedded_hor_view';
        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'result' => $this->fixed_data, 'row_count' => $this->total_rows, 'flavor_text' => $this->form_text, 'css' => $this->css, 'js' => $this->js
        ))->get();
    }
}

class ModalEmbedWidget extends WidgetTypes {

    public $width = 760;
    public $height = 500;

    public function __construct($options) {
        $this->form_text  = $options->form_text;
        $this->fixed_data = $options->fixed_data;
        $this->total_rows = $options->total_rows;
        $this->css  = HTML::style('themes/widget/'.$options->theme_type.'/css/'.$options->theme_type.'_popup_style.css');
        $this->css .= HTML::style('css/widget_master/ie_fix.css');
        $this->js = HTML::script('js/widget/popup.js');  
    } 

    public function render() {
        $widget_view = 'widget::widget_modal_popup_view';
        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'result' => $this->fixed_data, 'row_count' => $this->total_rows, 'flavor_text' => $this->form_text, 'css' => $this->css, 'js' => $this->js
        ))->get();
    }
}
