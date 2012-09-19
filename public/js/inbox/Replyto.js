jQuery(function($) {
    $('.dialog-form').dialog({
        autoOpen: false  
      , height: 600
      , width: 700
      , modal: true
      , buttons: { 
            "Send Reply": function() { 
                 //alert("Reply Successful!");
                 //$(this).dialog('close');
                 var form = $(this).children('form');
                 var me = $(this);
                 form.ajaxSubmit({
                     dataType: 'json'     
                   , success: function(data, textStatus) {
                         me.dialog('close');
                     }
                 });
            }
          , Cancel: function() { $(this).dialog('close'); }
        }
      , close: function(e, ui) {    
            var form = $(this).children('form');
            console.log($(form).children(".block > .regular-text").val(""));
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
        /*
        var pointer = $(this).index();
        var input = "<input type='text' class='regular-text' name='bcc[]' value='"+$(this).text()+"' />  <a class='delete-bcc' id='" + pointer + "' href='#'>[x]</a>";       
        var first_bcc = $("#first-bcc");
         
        if(first_bcc.val().length === 0) {
            first_bcc.val($(this).text());
            seen[pointer] = true;
        } else {
             if(typeof seen[pointer] == 'undefined') {  
               $("#bcc-target").append(input);
               seen[pointer] = true;
            }   
        }
 
        $(".delete-bcc").unbind("click.delete-bcc").bind("click.delete-bcc", function(e) {
            var del_pointer = $(this).attr('id');
            $(this).prev('input').remove().end().remove();
            delete seen[del_pointer];
            e.preventDefault();
        })
        */ 
        e.preventDefault();
    })
});
