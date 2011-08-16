function FeedbackDisplayToggle(opts) {
    this.feed_id      = opts.feed_id;
    this.hrefaction   = opts.hrefaction;
}

FeedbackDisplayToggle.prototype.toggleDisplays = function(user_display, column) {     
    var me = this;

    user_display.bind('click', function(e) {   
        var val = this.checked;
        var name = $(this).attr('name');
        var feed_id = me.feed_id.val();
        var hrefaction = me.hrefaction.attr('hrefaction');

        var dict = {};
        dict[column] = feed_id;
        dict.check_val = val;
        dict.column_name = name;
       
        me._postToggleChange(hrefaction, dict);
    });
}

FeedbackDisplayToggle.prototype._postToggleChange = function(hrefaction, opts) { 
    jQuery.ajax({ type: "POST", url: hrefaction, data: opts });
}
