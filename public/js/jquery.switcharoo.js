(function($) {
    
$.fn.switcharoo = function(background_pos) {
    $(this).bind('click', function(e) { 
        var feedurl = $(this).attr('hrefaction');
        var feedid = $(this).attr('feedid');
        var state = $(this).attr('state');
        var class_name = $(this).attr('class');

        var var_state;
        var var_status_message;
        var col;

        if(state == 0) {
            var_state = 1;
            $(this).attr('state', 1);
            $(this).css({'background-position': background_pos});

            var reset_cat_state = $(this).siblings('.fileas').siblings('.category-picker-holder').children('.category-picker').children('li').removeClass("Matched")
                                         .end().children('li:first-child').addClass("Matched");

            if(class_name == 'check') {
                $(this).siblings('.feature').removeAttr('style').attr('state', 0);
                reset_cat_state;
            }
           
                     
            if(class_name == 'feature') {
                $(this).siblings('.check').removeAttr('style').attr('state', 0);
                reset_cat_state;
            }
        }

        if(state == 1) {
            var_state = 0;
            $(this).attr('state', 0);
            $(this).removeAttr('style');
        }

        if(class_name == 'check') {
           var_status_message = $("<span>PUBLISHED</span>").attr("publ-id", feedid);
           col = 'publish';
        } 

        if(class_name == 'feature') {
           var_status_message = $("<span>FEATURED</span>").attr("feat-id", feedid); 
           col = 'feature';
        } 

        if(class_name == 'flag') { 
           var_status_message = $("<span>FLAGGED</span>").attr("flagged-id", feedid); 
           col = 'flag';
        } 
 
        var status_message_elem = $(this).parents('.right')
                                         .children('.status-message')
                               
        if(class_name == 'check' || class_name == 'feature') {
            status_message_elem.html( ((state == 0) ? var_status_message : null) );
        } else {
            status_message_elem.append( ((state == 0) ? var_status_message : null) );
        }

        var pub = $("span[publ-id="+feedid+"]");
        var feat = $("span[feat-id="+feedid+"]");
        var flag = $("span[flagged-id="+feedid+"]");

        if(state == 0) { 
            if(class_name == 'check') 
                pub.css( {"background-color": "#228B22", "color": "#f0f0f0"} );

            if(class_name == 'feature') 
                feat.css( {"background-color": "#FFB00F", "color": "#f0f0f0"} );

            if(class_name == 'flag') 
                flag.css( {"background-color": "#8B2323", "color": "#f0f0f0"} );

        } else { 
            
            if(class_name == 'check') 
                pub.remove();

            if(class_name == 'feature') 
               feat.remove();

            if(class_name == 'flag') 
                flag.remove();
           
        }
    
        $.ajax( { type: "POST", url: feedurl, data: {"col": col, "state": var_state, "feed_ids": [ {"feedid": feedid} ]} } );
        e.preventDefault(); 
    });
}
})(jQuery);
