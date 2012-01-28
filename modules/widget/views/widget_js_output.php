<?php
   //header("Content-type: application/x-javascript");
   header("Content-type: text/javascript; charset=UTF-8");
?>

function WidgetLoader(opts) {
    this.company_id = opts.companyId;
    this.username = opts.user;
    this.widget_id = opts.widgetId;
}

WidgetLoader.prototype.generateFrameMarkup = function() {
    var that = this;    
    var frameUrl = '<?=$deploy_url?>/widget/widget_loader/'+that.widget_id+'/'+that.username+'/'+that.company_id+'/';
    var src = '<span style="z-index:100001"><iframe id="s36Widget" allowTransparency="true" frameborder="0" scrolling="no" style="width:100%;border:none;overflow:visible;" src="'+frameUrl+'">Insomnia wooohooooh</iframe></span>';
    return src;
}

WidgetLoader.prototype.display = function() { 
    document.write(this.generateFrameMarkup());
}
