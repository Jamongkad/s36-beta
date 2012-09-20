jQuery(function($) {
    $('.dialog-form').dialog({
        autoOpen: false  
      , height: 600
      , width: 700
      , modal: true
      , buttons: { 
            "Send Reply": function() { 
                 //alert("Reply Successful!"); 
                 var form = $(this).children('form');
                 var me = $(this);
                 form.ajaxSubmit({
                     dataType: 'json'     
                   /*
                   , success: function(data, textStatus, jqXHR) {
                         console.log(textStatus);
                         console.log(data);
                         console.log(me);
                     }
                   */
                 });
                 me.dialog('close');
            }
          , Cancel: function() { $(this).dialog('close'); }
        }
      , close: function(e, ui) {    
            $(".regular-text[name=bcc], .regular-text[name=message]").val("");
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

    var seen = {};
    $('.add-bcc > li a').bind("click", function(e) {

        var my_id = $(this).attr('feedid');
        var textarea = $(".bcc-target[feedid="+my_id+"]").children('textarea');
        var email = $(this).attr('email');

        textarea.val(textarea.val() + email + ","); 
        e.preventDefault();
    })
});
