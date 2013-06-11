function DropDownChange(opts) {
    this.status_element = opts.status_element;    
    this.status_selector = opts.status_selector;
}

DropDownChange.prototype.enable = function() {
    var mouse_is_inside = false;
    var me = this;     
    $(document).delegate(me.status_element, 'hover', function(e) {
        if(e.type === 'mouseenter') {
            mouse_is_inside = true;     
        } else {
            mouse_is_inside = false;  
        }
    })

    $(document).delegate(me.status_element, 'click', function(e) { 
        var that = this;
        $(that).children('span').hide();
        $(that).children('select').show();
        $(that).undelegate(me.status_selector).delegate('select', me.status_selector, function(e) {
            var select = $(this);
            var select_text = $('option[value="'+select.val()+'"]', this).text();
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
            select.siblings().text(select_text); 
        });

        $(document).delegate('body', 'click', function(e) {
            if(!mouse_is_inside) {
                $(that).children('span').show();
                $(that).children('select').hide();
            }
        })
    });

}
