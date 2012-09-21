angular.module('reply', [])
.directive('myReply', function() {
    return function(scope, element, attrs) {
        $(element).bind('click', function(e) { 
            var feedid = $(this).attr('feedid'); 
            $('.dialog-form[feedid='+feedid+']').dialog('open'); 
            e.preventDefault();
        });
    }
})
.directive('replyCancel', function(){
    return function(scope, element, attrs){
        $(element).bind('click', function(e) {
            $(this).parents('form textarea[name=bcc] textarea[name=message]').clearFields();
            $(this).parents('.dialog-form').dialog('close');
            e.preventDefault();
        });
    }
})
.directive('replySend', function() {
    return function(scope, element, attrs){
        $(element).bind('click', function(e) {
            var form = $(this).parents('form');
            $(this).parents('form textarea[name=bcc] textarea[name=message]').clearFields();
            form.ajaxSubmit({
                dataType: 'json'     
            })
            e.preventDefault();
        });
    }
})
.directive('replyBcc', function() {
    return function(scope, element, attrs){
        $(element).children('li').bind('click', function(e) {
            var children = $(this).children('a');
            var email = children.attr('email');
            var my_id = children.attr('feedid');
            var textarea = $(".bcc-target[feedid="+my_id+"]").children('textarea');

            textarea.val(textarea.val() + email + ","); 
            e.preventDefault();
        });
    }
 
})


$('.dialog-form').dialog({
    autoOpen: false  
  , height: 600
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
    */
  , close: function(e, ui) {    
        $(".regular-text[name=bcc], .regular-text[name=message]").val("");
    }
});

