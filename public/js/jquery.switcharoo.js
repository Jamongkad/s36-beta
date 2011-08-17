(function($) {
    
$.fn.switcharoo = function(background_pos) {
    $(this).bind('click', function(e) { 
        var feedurl = $(this).attr('hrefaction');
        var feedid = $(this).attr('feedid');
        var state = $(this).attr('state');

        var var_state = null;

        if(state == 0) {
            var_state = 1;
            $(this).attr('state', 1);
            $(this).css({'background-position': background_pos});
        }

        if(state == 1) {
            var_state = 0;
            $(this).attr('state', 0);
            $(this).removeAttr('style');
        }

        $.ajax({
              type: "POST"
            , url: feedurl
            , data: {"state": var_state, "feedid": feedid}
        });

        e.preventDefault(); 
    });
}
})(jQuery);
