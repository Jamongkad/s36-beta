angular.module('reply', [])
.directive('myReply', function() {
    return function(scope, element, attrs) {
        $(element).bind('click', function(e) { 
            var feedid = $(this).attr('feedid'); 
            $('.dialog-form[feedid='+feedid+']').dialog('open'); 
            $('.ui-dialog-titlebar').hide();
            e.preventDefault();
        });
    }
})

$('.dialog-form').dialog({
    autoOpen: false  
  , height: 550
  , width: 700
  , modal: true
  /*
  , buttons: { 
        "Send Reply": function() { 
             //alert("Reply Successful!"); 
             var form = $(this).children('form');
             var me = $(this);
             form.ajaxSubmit({
                 dataType: 'json'     
             });
             me.dialog('close');
        }
      , Cancel: function() { $(this).dialog('close'); }
    }
  , close: function(e, ui) {    
        $(".regular-text[name=bcc], .regular-text[name=message]").val("");
    }
    */
});

//fucking fix
