<?php 
session_cache_limiter("private_no_expire"); 
header("Content-type: application/x-javascript; charset=UTF-8"); 
?>
function WidgetLoader() {
    this.generateFrameMarkup = function() {
        <?if($class_name == 'Widget\Entities\VerticalEmbedWidget' || $class_name == 'Widget\Entities\HorizontalEmbedWidget'):?>
            var src = '<?=$js_load?>' + 
                      '<?=$css_load?>' + 
                      '<div style="position:relative;width:<?=$width?>px;height:<?=$height?>px;">' +
                      '<div class="s36_<?=$embed_block_type?>"><a href="javascript:;" onclick="s36_openForm(\'<?=$widget_child_loader_url?>\');">Send Feedback</a></div>' +
                      '<iframe id="s36Widget" allowTransparency="true" height="<?=$height?>" width="<?=$width?>"frameborder="0" scrolling="no" style="width:100%;border:none;overflow:hidden;" src="<?=$widget_loader_url?>">Insomnia wooohooooh</iframe></div>';
        <?endif?>
        <?if($class_name == 'Widget\Entities\ModalEmbedWidget'):?>
            var src = '<?=$js_load?>'+ 
                      '<?=$css_load?>' + 
                      '<div class="s36_embed_block_p"><a href="javascript:;" onclick="s36_open_popup_widget()">Display Feedback</a></div>'+
                      '<div id="s36PopupWidgetShadow">'+
                      '<div id="s36PopupWidgetBox">'+
                      '<div id="s36PopupWidgetSendFeedback" onclick="s36_openForm(\'<?=$widget_child_loader_url?>\')">Send Feedback</div><div id="s36_closebtn" onclick="s36_closePopupWidget()"></div>'+
                      '<iframe id="s36Widget" allowTransparency="true" height="520" frameborder="0" scrolling="no" style="width:100%;border:none;overflow:visible;" src="<?=$widget_loader_url?>"></iframe></div></div>';
        <?endif?>
        return src;    
    },

    this.display = function() {  
        document.write(this.generateFrameMarkup());
    }
}

var dis  = new WidgetLoader();
dis.display();
