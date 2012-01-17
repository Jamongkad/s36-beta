function Status() {
    this.message = "#notification-message";
    this.notification = "#notification";
}

Status.prototype.notify = function(msg, delay) { 
    var me = this;
	var delay = delay;
    console.log("This should be firing.");
	$(me.message).empty().html(msg).show(); 
    $(me.notification).animate({height: '50', opacity: '100'}, 'fast', '', function() { 
		if(delay){
			setTimeout(function() {
                $(me.notification).slideUp();               
            },delay);		
		}
    });
    
    /*
	$(me.notification).slideDown(100,function(){
		if(delay){
			setTimeout(function() {
                $(me.notification).slideUp();               
            },delay);		
		}
	});
    */
}
