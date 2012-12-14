angular.module('reply', [])
.directive('myReply', function(MessageService) {    
    return {
        restrict: 'A'       
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var feedid = $(this).attr('feedid');  

                MessageService.fetch_messages('msg');
                MessageService.register_reply_message();

                $('div#reply-to-user').draggable();
                $(".dialog-form[feedid="+feedid+"]").fadeIn();
                e.preventDefault();
            });
        }
    } 

})
.directive('replyCancel', function(){
    return function(scope, element, attrs){
        $(element).bind('click', function(e) {
            $(this).parents('form textarea[name=bcc] textarea[name=message]').clearFields();
            $(this).parents(".dialog-form").fadeOut();
            console.log("this should close");
            e.preventDefault();
        });
    }
})
.directive('replySend', function() {
    return function(scope, element, attrs){
        $(element).parents('form').validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function() {
                        alert("Your reply has been sent!");
                        $(element).parents(".dialog-form").fadeOut();
                        $(element).parents('form textarea[name=bcc] textarea[name=message]').clearFields();
                    }        
                });
            }
		  , errorElement: "em"
          , rules: {
                message: {
                    required: true     
                }
            }
        });
    }
})
.directive('addReply', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                var quickmessage = $(this).attr('req-text');
                var textarea = $("textarea[name=message]");
                textarea.val(quickmessage); 
                e.preventDefault();
            });
        }
    }  
})
.directive('deleteReply', function() {
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
            $(element).bind("click", function(e) {
                $(this).parents('li').remove();
                e.preventDefault();
            })
        }
    }    
})
.directive('editReply', function() {
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
            $(element).bind("click", function(e) { 
                var msgid    = $(this).parents('span').siblings('a').attr('id');
                var req_text = $(this).parents('span').siblings('a').attr('req-text');
                var configure = $('.modal-configure');
                configure.dialog({ zIndex: 100001 });
                configure.dialog('open');
                configure.children('#msgid').val(msgid);
                configure.children('.regular-text').val(req_text);
                configure.children('#msgtype').val("msg");
                configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Update");
                e.preventDefault();
            }) 
        }
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
.directive('configureReply', function() { 
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                var configure = $('.modal-configure');
                configure.dialog({ zIndex: 100001 });
                configure.dialog('open');
                configure.children('.regular-text').val("");
                configure.children('#msgid').val("");
                configure.children('#msgtype').val("msg");
                configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Add");
                e.preventDefault();
            })
        }
    }   
})
.directive('cancelReply', function() { 
    return {
        restrict: 'A'
      , link: function(scope, element, attr) {
            $(element).bind("click", function(e) { 
                var configure = $('.modal-configure');
                configure.dialog('close');
            })
        }
    }    
})
