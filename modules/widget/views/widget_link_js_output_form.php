<?php 
#session_cache_limiter("private_no_expire"); 
#header("Content-type: application/x-javascript; charset=UTF-8"); 
?>
<?=$js_load?>
<?=$css_load?>
<script type="text/javascript">
function s36FormLink() {
	this.generateTab= function(){
        var src = '<a href="#" onclick="s36_openForm(\'<?=$widget_loader_url?>\');javascript::void(0);">Click to open feedback form</a>';				
        return src;
	},
	this.display = function () {
        document.write(this.generateTab());
    }	
    
}
var link = new s36FormLink();
link.display();
</script>
