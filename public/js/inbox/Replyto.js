jQuery(function($) {
    $('.dialog-form').dialog({
        autoOpen: false  
      , height: 550 
      , width: 700
      , modal: true
      , buttons: { 
            "Send Reply": function() { 
                 alert("Reply Successful!");
                 $(this).dialog('close');
            }
          , Cancel: function() { $(this).dialog('close'); }
        }
    });

    $(document).delegate('.reply', 'click', function(e) {
        var feedid = $(this).attr('feedid');
        $('.dialog-form[feedid='+feedid+']').dialog('open');
        e.preventDefault();
    });

    /* Old reply implementation
    $('.reply').bind("click", function(e) {     
        var href = $(this).attr('hrefaction');
        window.location = href;
        e.preventDefault();
    })
    */

});
