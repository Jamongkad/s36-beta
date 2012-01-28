function s36Widget(){
	this.frameUrl = '',
	this.init = function(params){
        console.log(params);
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
