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

            var form = $(this).parents('form');
            var message_textarea = $("textarea[name=message]", form);
            message_textarea.css({'border': '1px solid #CCCCCC'})

            e.preventDefault();
        });
    }
})
.directive('replySend', function() {
    return function(scope, element, attrs){

        var error_msg = $(".reply-box-error");

        $(element).bind('click', function(e) {
            var form = $(this).parents('form');
            var myparent = $(this).parents('.dialog-form')
            var message_textarea = $("textarea[name=message]", form);
  
            if(message_textarea.val().length == 0) { 
                message_textarea.css({'border': '2px solid red'}) 
                return error_msg.html("reply message required");
                e.preventDefault();
            } else { 
                message_textarea.css({'border': '1px solid #CCCCCC'})
                form.ajaxSubmit({
                    dataType: 'json'     
                  , success: function(data) {
                        alert("Your reply has been sent!");
                        myparent.dialog('close');
                    }
                })
                $(this).parents('form textarea[name=bcc] textarea[name=message]').clearFields();

            }
           
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
.directive('msgsel', function() {
    var msgsel_fn;

    msgsel_fn = function(scope, element, attrs) {
        $(element).children('li[id]').bind('click', function(e) {
            //console.log($(this).text());     
            var quickmessage = $(this).text();
            var textarea = $(this).parents('td').prev('td').children('textarea');

            textarea.val(quickmessage); 
            e.preventDefault();
        });
    }

    return {
        restrict: 'C'     
      , link: msgsel_fn
    }  
})

//dialog form init
$('.dialog-form').dialog({
    autoOpen: false  
  , height: 627
  , width: 700 
  , modal: true
  , close: function(e, ui) {    
        $(".regular-text[name=bcc], .regular-text[name=message]").val("");
    }
});
