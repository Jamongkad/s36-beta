function DropDownChange(opts) {
    this.status_element = opts.status_element;    
    this.status_selector = opts.status_selector;
}

DropDownChange.prototype.enable = function() {
    var me = this;     
    $(document).delegate(me.status_element, 'click', function(e) { 
        var that = this;
        $(that).children('span').hide();
        $(that).children('select').show();
        $(that).undelegate(me.status_selector).delegate('select', me.status_selector, function(e) {
            var select = $(this);
            console.log(select.text());
            var select_val = select.val();
            var feedid = select.attr('feedid');
            var feedurl = select.attr('feedurl');
            $.ajax({
                  type: "POST"
                , url: feedurl
                , data: {"select_val": select_val, "feed_id": feedid}
                , success: function() { 
                    var myStatus = new Status();
                    myStatus.notify("Processing...", 1000);
                    select.hide();
                    $(that).children('span').show();
                }
            }); 
            select.siblings().text(select_val); 
        });
    })
}
