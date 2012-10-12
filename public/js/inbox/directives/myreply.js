angular.module('reply', [])
.directive('myReply', function(MessageService) {    
    return {
        restrict: 'A'       
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var feedid = $(this).attr('feedid');  
                MessageService.fetch_reply_messages();
                $('.dialog-form[feedid='+feedid+']').dialog('open'); 
                e.preventDefault();
            });
        }
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
        $(element).parents('form').validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function() {
                        alert("Your reply has been sent!");
                        $(element).parents('.dialog-form').dialog('close'); 
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
                var reply_configure = $('.modal-configure');

                reply_configure.dialog('open');
                reply_configure.children('#msgid').val(msgid);
                reply_configure.children('.regular-text').val(req_text);
                reply_configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Update");
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
                var reply_configure = $('.modal-configure');
                reply_configure.dialog('open');
                reply_configure.children('.regular-text').val("");
                reply_configure.children('#msgid').val("");
                reply_configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Add");
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
                var reply_configure = $('.modal-configure');
                reply_configure.dialog('close');
            })
        }
    }    
})
.directive('execReplyItem', function(MessageService) { 
    return {
        restrict: 'A'
      , link: function(scope, element, attr) {
            $(element).bind("click", function(e) {
                var reply_configure = $('.modal-configure');
                var msgid = reply_configure.children('#msgid').val();
                var text  = reply_configure.children('.regular-text').val();

                if(text.length == 0) {
                    alert("This field cannot be blank.");
                } else {      
                    if(msgid || msgid.length > 0) {

                        var msg_obj = {'type': 'msg', 'msg': text, 'id': msgid}
                        MessageService.update(msg_obj);

                        var a_msg = $("a#"+msgid);
                        a_msg.attr('req-text', MessageService.editdata.text);
                        a_msg.attr('id', MessageService.editdata.id);
                        a_msg.html(MessageService.editdata.short_text);

                    } else {    
                        MessageService.save({'type': 'msg', 'msg': text});
                        MessageService.fetch_reply_messages();
                    }
                    reply_configure.dialog("close");
                }
            });
        }
    }    
})

//dialog form init
$('.dialog-form').dialog({
    autoOpen: false  
  , height: 680
  , width: 700 
  , modal: true
  , close: function(e, ui) {    
        $(".regular-text[name=bcc], .regular-text[name=message]").val("");
    }
});
