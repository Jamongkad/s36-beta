<?php

class WidgetGenerator {

    public $option_obj, $base_url;


    public function __construct($option_obj) {
        $this->base_url    = URL::to('/');
        $this->option_obj  = $option_obj;

        $this->siteId    = $this->option_obj->site_id;
        $this->companyId = $this->option_obj->company_id;

        $this->form_widget = $this->base_url."widget/form?siteId={$this->siteId}&companyId={$this->companyId}" ;
    }

    public function generate_widget_code() {
        if($this->option_obj->embed_type == 'embedded') {
            return $this->generate_iframe_code();
        }
        
        if($this->option_obj->embed_type == 'modal') {
            return trim('<a href="javascript:;" id="s36m_widget_1">display modal</a>');
        }

        return false;
    }

    public function generate_init_code() { 
        $modal_code = null;
        if($this->option_obj->embed_type == 'modal') {
            
            $modal_widget_src = $this->base_url."widget/modal?siteId={$this->siteId}&companyId={$this->companyId}&is_published=1&is_featured=1";

            $effect = $this->_effect_name($this->option_obj->effect);
 
            $modal_code = trim(" 
                var m_option_1 = {
                    target 		: 's36m_widget_1'
                  , siteId 		: siteId
                  , companyId 	: companyId
                  , transition 	: '{$effect->jqueryname}'
                  , template 	: 'default'
                  , widget_src	: '{$modal_widget_src}'
                }
                var m_widget_1 = s36_modal_widget(m_option_1);
            "); 
        }
           
        return trim("
                <!--Stick this plugin in the HEAD portion of your web page-->
                <link rel='stylesheet' type='text/css' href='{$this->base_url}css/s36_client_style.css' />
                <script type='text/javascript' src='{$this->base_url}js/s36_client_script.js'></script>
                <script type='text/javascript'>	
                        DomReady.ready(function() {
                            var siteId = {$this->siteId};
                            var companyId = {$this->companyId};
                            var s36_button_opts = {
                                siteId 		: siteId
                              , companyId 	: companyId
                              , form_url    : '{$this->form_widget}'
                            }  
                            var s36_button = s36_create_widget_button(s36_button_opts);  
                            $modal_code 
                        });
                </script>
        ");
    }

    public function generate_iframe_code() {

        $effect = $this->_effect_name($this->option_obj->effect);

        if($this->option_obj->embed_type == 'embedded') {
            $width  = $this->option_obj->width;
            $height = $this->option_obj->height;
            $type   = ($this->option_obj->type == 'embed_block_x') ? 'horizontal' : 'vertical';
            $units  = $this->option_obj->units;

            return trim("
               <iframe src='{$this->base_url}widget/embedded?siteId={$this->siteId}&companyId={$this->companyId}&is_published=1&is_featured=1&transition={$effect->jqueryname}&type={$type}&units={$units}' 
                width='{$width}' height='{$height}' 
                scrolling='no' frameborder='0'>
                   Sorry your browser doe not support iframes
               </iframe>
            ");
        }
        
        if($this->option_obj->embed_type == 'modal') {
            return trim("
                <iframe src='{$this->base_url}widget/modal?siteId={$this->siteId}&companyId={$this->companyId}&is_published=1&is_featured=1&transition={$effect->jqueryname}'
                 width='750' height='440' scrolling='no' frameborder='0'>
                   Sorry your browser doe not support iframes       
                </iframe>
            ");
        }

    }

    private function _effect_name($effectsId) { 
        return DB::Table('Effects', 'master')->where('effectsid', '=', $effectsId)->first(Array('jqueryname'));
    }

}

abstract class WidgetTypes {
    
    private $option_parameters;

    public function __construct($option_parameters) {
        $this->option_parameters = $option_parameters;    
    }
    
    public abstract function generate_html_code();
}

class FullPageType extends WidgetTypes {
    public function generate_html_code() {}
}


class EmbeddedType extends WidgetTypes { 
    public function generate_html_code() {}
}

class ModalType extends WidgetTypes { 
    public function generate_html_code() {}
}
