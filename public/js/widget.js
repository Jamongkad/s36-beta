function s36Widget(){
	this.frameUrl = '',
	this.init = function(params){
		for (key in params){
			this[key] = params[key]; // get the parameters!
		}
		this.generateWidgetUrl();
	},
	this.generateWidgetUrl = function(){
		var url = 'http://localhost/new_template/aglow/760x300_Leaderboard.php?';
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