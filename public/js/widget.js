function WidgetLoader(opts) {
    this.company_id = opts.companyId;
    this.username = opts.user;
    this.widget_id = opts.widgetId;
}

WidgetLoader.prototype.generateFrameMarkup = function() {
    var that = this;    
    var frameUrl = 'http://razer.gearfish.com/widget/widget_loader/'+that.widget_id+'/'+that.username+'/'+that.company_id+'/';
    var src = '<span style="z-index:100001"><iframe id="s36Widget" allowTransparency="true" height="300" frameborder="0" scrolling="no" style="width:100%;border:none;overflow:visible;" src="'+frameUrl+'">Insomnia wooohooooh</iframe></span>';
    return src;
}

WidgetLoader.prototype.display = function() { 
    document.write(this.generateFrameMarkup());
}

WidgetLoader.prototype.test = function() {
    console.log(jamongkad.name);
}
