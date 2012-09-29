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

            var error_msg = $(".reply-box-error");
            error_msg.css({'background': '#fff'})
            error_msg.html("");

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
        //console.log();
        //
        $(element).parents('form').submit(function(e) {
            var me = $(this);
            $(this).ajaxSubmit({
                beforeSubmit: function(formData, jqForm, options) {
                    console.log($('textarea', me));
                    //console.log($('textarea[name=message]', me).validationEngine('validate'));
                }
            })
            e.preventDefault();
        })
        /*
         *
        $(element).bind('click', function(e) {
            
            var form = $(this).parents('form');
            form.ajaxSubmit();

            e.preventDefault();
        });
        */
        //var error_msg = $(".reply-box-error");

        //$(element).bind('submit', function(e) {
            /*
            var form = $(this).parents('form');
            var myparent = $(this).parents('.dialog-form')
            console.log(form);
            form.ajaxSubmit({
                dataType: 'json'     
              , success: function(data) {
                    alert("Your reply has been sent!");
                    myparent.dialog('close');
                }
            })
            /*
            var form = $(this).parents('form');
            var myparent = $(this).parents('.dialog-form')
            form.ajaxSubmit({
                dataType: 'json'     
              , success: function(data) {
                    alert("Your reply has been sent!");
                    myparent.dialog('close');
                }
            })
            $(this).parents('form textarea[name=bcc] textarea[name=message]').clearFields();
            */
            /*
            var form = $(this).parents('form');
            var myparent = $(this).parents('.dialog-form')
            var message_textarea = $("textarea[name=message]", form);
  
            if(message_textarea.val().length == 0) { 
                message_textarea.css({'border': '2px solid red'}) 
                error_msg.show();
                error_msg.css({'background': '#ffa801'})
                error_msg.html("reply message required");
            } else { 
                message_textarea.css({'border': '1px solid #CCCCCC'})
                error_msg.css({'background': '#fff'})
                error_msg.html("");
                form.ajaxSubmit({
                    dataType: 'json'     
                  , success: function(data) {
                        alert("Your reply has been sent!");
                        myparent.dialog('close');
                    }
                })
                $(this).parents('form textarea[name=bcc] textarea[name=message]').clearFields();
            }
            */
           
            //e.preventDefault();
        //});
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
  , height: 670
  , width: 700 
  , modal: true
  , close: function(e, ui) {    
        $(".regular-text[name=bcc], .regular-text[name=message]").val("");
    }
});
$('.reply-form').validationEngine('validate')

