
angular.module('reply', [])
.directive('myReply', function() {

    var linkfn = function(scope, element, attrs) {

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

        $(element).bind('click', function(e) {
            var feedid = $(this).attr('feedid'); 
            $('.dialog-form[feedid='+feedid+']').dialog(
            
            ); 
            console.log(feedid);
            e.preventDefault();
        });
    }

    return {
        link: linkfn
    }

})
