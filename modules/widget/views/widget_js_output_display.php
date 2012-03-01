<?php 
session_cache_limiter("private_no_expire"); 
header("Content-type: application/x-javascript; charset=UTF-8"); 
?>
function WidgetLoader() {
    this.generateFrameMarkup = function() {
        var src = '<?=$js_load?>' + 
                  '<?=$css_load?>' + 
                  '<div style="position:relative;width:<?=$width?>px;height:<?=$height?>px;">' +
                  '<div class="s36_<?=$embed_block_type?>"><a href="javascript:;" onclick="s36_openForm(\'<?=$widget_child_loader_url?>\');">Send Feedback</a></div>' +
                  '<iframe id="s36Widget" allowTransparency="true" height="<?=$height?>" width="<?=$width?>"frameborder="0" scrolling="no" style="width:100%;border:none;overflow:hidden;" src="<?=$widget_loader_url?>">Insomnia wooohooooh</iframe></div>';
        return src;    
    },

    this.display = function() {  
        document.write(this.generateFrameMarkup());
    }
}

var dis  = new WidgetLoader();
dis.display();
