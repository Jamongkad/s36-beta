<?php 
session_cache_limiter("private_no_expire"); 
header("Content-type: application/x-javascript; charset=UTF-8"); 
?>
function s36Tab() {
	this.generateTab= function(){
        var src = '<?=$js_load?>' + 
                  '<?=$css_load?>' + 
                  '<?=$tab_position_css?>' + 
				  '<div id="s36LeaveFeedback" onclick="s36_openForm(\'<?=$widget_loader_url?>\');" class="tab-<?=$tab_pos?>tab <?=$tab_type?>"></div>';				
        return src;
	},
	this.display = function () {
        document.write(this.generateTab());
    }	
}
var tab = new s36Tab();
tab.display();
