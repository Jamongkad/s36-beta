/*
function s36Widget(){
	this.frameUrl = '',
	this.init = function(params){
         
		//this.generateWidgetUrl();
	},
	this.generateWidgetUrl = function(){
        var url = 'http://razer.gearfish.com/widget/embedded_proto/iuz0h/ryan/1/';
		this.frameUrl = url;
	},
	this.generateFrameMarkup = function(){
        var src = '<span style="z-index:100001"><iframe id="s36Widget" allowTransparency="true" height="300" frameborder="0" scrolling="no" style="width:100%;border:none;overflow:visible;" src="'+this.frameUrl+'"><a href="javascript:;" title="html form">Fill out my Wufoo form!</a></iframe></span>';
        return src;
	},
	this.display = function () {
        document.write(this.generateFrameMarkup());
    }	
}
*/
function WidgetLoader(opts) {
    this.company_id = opts.companyId;
    this.username = opts.user;
    this.widget_id = opts.widgetId;
}

WidgetLoad.prototype.generateFrameMarkup = function() {
    var that = this;    
    var frameUrl = 'http://razer.gearfish.com/widget/embedded_proto/'+that.widget_id+'/'+that.username+'/'+that.company_id+'/';
    var src = '<span style="z-index:100001"><iframe id="s36Widget" allowTransparency="true" height="300" frameborder="0" scrolling="no" style="width:100%;border:none;overflow:visible;" src="'+frameUrl+'"><a href="javascript:;" title="html form">Fill out my Wufoo form!</a></iframe></span>';
    return src;
}

WidgetLoader.prototype.display = function() { 
    document.write(this.generateFrameMarkup());
}


