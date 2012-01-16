function Status() {
    this.message = "#notification-message";
    this.notification = "#notification";
}

Status.prototype.notify = function(msg, delay) { 
    var me = this;
	var delay = delay;
	$(me.message).empty().html(msg).show();
	$(me.notification).slideDown(100,function(){
		if(delay){
			setTimeout(function() {
                $(me.notification).slideUp();               
            },delay);		
		}
	});
}
