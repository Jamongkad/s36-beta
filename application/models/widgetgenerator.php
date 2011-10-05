<?php

class WidgetGenerator {

    public $option_obj, $base_url;


    public function __construct($option_obj) {
        $this->option_obj  = $option_obj;
    }

    public function generate_widget_code() {
        if($this->option_obj->embed_type == 'embedded') {
            $embedded = new EmbeddedType($this->option_obj);
            return $embedded->generate_html_code(); 
        }
        
        if($this->option_obj->embed_type == 'modal') {
            return trim('<a href="javascript:;" id="s36m_widget_1">display modal</a>');
        }

        return false;
    }

    public function generate_init_code() { 
        $modal = new ModalType($this->option_obj);
        return $modal->generate_modal_init_code(); 
    }

    public function generate_iframe_code() {

        if($this->option_obj->embed_type == 'embedded') {
            $embedded = new EmbeddedType($this->option_obj);
            return $embedded->generate_html_code(); 
        }
        
        if($this->option_obj->embed_type == 'modal') {
            $modal = new ModalType($this->option_obj);
            return $modal->generate_html_code(); 
        }

    }
}

abstract class WidgetTypes {

    public $option_obj;
    
    public function __construct($option_parameters) {
        $this->option_obj = $option_parameters;    
        $this->base_url   = URL::to('/'); 
        $this->siteId    = $this->option_obj->site_id;
        $this->companyId = $this->option_obj->company_id;
        $this->themeId   = $this->option_obj->theme_id;
    }
    
    public abstract function generate_html_code();
}

class FullPageType extends WidgetTypes {
    public function generate_html_code() {}
}


class EmbeddedType extends WidgetTypes { 
    public function generate_html_code() { 
        $effect = _effect_name($this->option_obj->effect);
        $width  = $this->option_obj->width;
        $height = $this->option_obj->height;
        $type   = ($this->option_obj->type == 'embed_block_x') ? 'horizontal' : 'vertical';
        $units  = $this->option_obj->units;

        return trim("
           <iframe src='{$this->base_url}widget/embedded?siteId={$this->siteId}&companyId={$this->companyId}&themeId={$this->themeId}&is_published=1&is_featured=1&transition={$effect->jqueryname}&type={$type}&units={$units}' 
            width='{$width}' height='{$height}' 
            scrolling='no' frameborder='0'>
               Sorry your browser doe not support iframes
           </iframe>
        ");

    }
}

class ModalType extends WidgetTypes { 
    public function generate_html_code() { 
        $effect = _effect_name($this->option_obj->effect);
        return trim("
            <iframe src='{$this->base_url}widget/modal?siteId={$this->siteId}&companyId={$this->companyId}&themeId={$this->themeId}&is_published=1&is_featured=1&transition={$effect->jqueryname}'
             width='750' height='440' scrolling='no' frameborder='0'>
               Sorry your browser doe not support iframes       
            </iframe>
        ");
    }

    public function generate_modal_init_code() {
        
        $modal_code = null;

        $form_widget = $this->base_url."widget/form?siteId={$this->siteId}&companyId={$this->companyId}&themeId={$this->themeId}";

        if($this->option_obj->embed_type == 'modal') {
            
            $modal_widget_src = $this->base_url."widget/modal?siteId={$this->siteId}&companyId={$this->companyId}&themeId={$this->themeId}&is_published=1&is_featured=1";

            $effect = _effect_name($this->option_obj->effect);
 
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
                              , form_url    : '{$form_widget}'
                            }  
                            var s36_button = s36_create_widget_button(s36_button_opts);  
                            $modal_code 
                        });
                </script>
        ");
    }
}

function _effect_name($effectsId) { 
    return DB::Table('Effects', 'master')->where('effectsid', '=', $effectsId)->first(Array('jqueryname'));
}
