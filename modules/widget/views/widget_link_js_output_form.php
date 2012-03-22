<?php 
#session_cache_limiter("private_no_expire"); 
#header("Content-type: application/x-javascript; charset=UTF-8"); 
?>
<script type="text/javascript">
function s36FormLink() {
	this.generateTab= function(){
        var src = '<?=$js_load?>' + 
                  '<?=$css_load?>' +  
				  '<a href="javascript;;" onclick="s36_openForm(\'<?=$widget_loader_url?>\');">Click to open feedback form</a>';				
        return src;
	},
	this.display = function () {
        document.write(this.generateTab());
    }	
    
}
var link = new s36FormLink();
link.display();
</script>
