function Status() {
    this.message = "#notification-message";
    this.notification = "#notification";
}

Status.prototype.notify = function(msg, delay) { 
    var me = this;
	var delay = delay;

	$(me.message).empty().html(msg).show();    
    $(me.notification).animate({height: '50', opacity: '100'}, 'fast', '', function() { 
		if(delay){
			setTimeout(function() {
                $(me.notification).animate({ height: 0, opacity: 0 }, 'fast'); 
            }, delay);		
		}
    });
}

Status.prototype.destroy = function() {
	$(me.message).hide();
}
