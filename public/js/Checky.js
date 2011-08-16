function Checky(opts) {
    this.delete_selection = opts.delete_selection;
    this.check_feed_id = opts.check_feed_id;
    this.click_all = opts.click_all;
}

Checky.prototype.init = function() {
    var me = this;    
   
    $(me.delete_selection).bind('change', function(e) {
        var mode = $(this).val();
        var checkFeed = me.check_feed_id;
        var ifChecked = checkFeed.is(':checked');
        var currentUrl = $(location).attr('href');

        var collection = new Array();
       
        if(ifChecked && mode != 'none') { 
            var conf = null; 
            if(mode == 'restore') 
                conf = confirm("Are you sure you want to restore these feedbacks?");

            if(mode == 'remove') 
                conf = confirm("Are you sure you want to permanently remove these feedbacks?");            

            if(mode == 'publish')
                conf = confirm("Are you sure want to publish these feedbacks?");

            if(mode == 'feature')
                conf = confirm("Are you sure want to feature these feedbacks?");

            if(mode == 'delete')
                conf = confirm("Are you sure want to delete these feedbacks?");

            if(conf) {
               checkFeed.each(function() {
                    if($(this).is(':checked')) {
                        collection.push($(this).val());
                        $('#' + $(this).val()).fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                });    
            }
            //revert to default -- select
            $("option:first", this).prop("selected", true);
            $.ajax({
                type: "POST"      
              , data: {col: mode, feed_ids: collection, curl: currentUrl}
              , url: $(this).attr("hrefaction")
              , success: function(msg) {
                    //$('.the-feedbacks').children().remove().end().html(msg);
                    //console.log(msg);
                    if(mode == 'restore') {
                        location.reload(); 
                    } 
                    checkFeed.attr('checked', false);
              }
            });
        } else {
            collection.length = 0;     
        } 
    });
}

Checky.prototype.clickAll = function() { 
    var me = this;    
    $(me.click_all).bind('click', function(e) {
        if(this.checked) {
            $(me.check_feed_id).prop("checked", true);
            $(me.click_all).prop("checked", true);
        } else {
            $(me.check_feed_id).prop("checked", false);
            $(me.click_all).prop("checked", false);
        }                                            
    });
}
