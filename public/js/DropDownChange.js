function DropDownChange(opts) {
    this.status_element = opts.status_element;    
    this.status_selector = opts.status_selector;
}

DropDownChange.prototype.enable = function() {
    var me = this;     
    me.status_element.bind("click", function(e) {
        $(this).children('span').hide();
        $(this).children('select').unbind(me.status_select).bind(me.status_selector, function(e) {
            var select = $(this);
            var select_val = select.val();
            var feedid = select.attr('feedid');
            var feedurl = select.attr('feedurl');
           
            $.ajax({
                  type: "POST"
                , url: feedurl
                , data: {"select_val":select_val, "feed_id": feedid}
                , success: function() { 
                    var myStatus = new Status();
                    myStatus.notify("Processing...", 1000);
                }
            });
            
            //select.siblings().text(select_val);
        }).show();

    }).css({'cursor': 'pointer'});
}
