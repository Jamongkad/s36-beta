angular.module('request', [])
.directive('myRequest', function() {
    return function(scope, element, attr) {
        $(element).bind('click', function(e) {
            $('.request-dialog').dialog('open');
            e.preventDefault();
        })
    }
})
.directive('myRequestClose', function() {
    return function(scope, element, attr) {
        $(element).bind('click', function(e) {
            $('.request-dialog').dialog('close');
            e.preventDefault();
        })
    }
    
})
.directive('myRequestSend', function() {
    return function(scope, element, attr) {
        $(element).parents('#request-form').validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit({ 
                    success: function(data) {
                        alert("Your request has been sent!");
                        $(form).clearForm();
                        $(element).parents('.request-dialog').dialog('close'); 

                    }
                }) 
            }
          , errorElement: "em"
          , rules: {
                first_name: { required: true }    
              , last_name: { required: true }
              , message: { required: true }
              , email: {
                    required: true   
                  , email: true 
                }
            }
        });
    } 
})
.directive('addRequest', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                var quickmessage = $(this).attr('req-text');
                var textarea = $("#recipient-message");
                textarea.val(quickmessage); 
                e.preventDefault();
            });
        }
    }  
})
.directive('deleteRequest', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                $(this).parents('li').remove();
                e.preventDefault();
            });
        }
    }  
})
.directive('editRequest', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                var msgid = $(this).attr('id');
                var request_configure = $('.modal-configure');
                var req_text = $(this).parents('span').siblings('a').attr('req-text');

                request_configure.dialog("open"); 
                request_configure.children('#msgid').val(msgid);
                request_configure.children('.regular-text').val(req_text);
                request_configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Update");

                e.preventDefault();
            });
        }
    }  
})
.directive('addRequestMsg', function() {
    return {
        restrict: 'C'
      , link: function(scope, element, attrs) { 
            $(element).bind('click', function(e) {
                var request_configure = $('.modal-configure');

                request_configure.dialog("open");
                request_configure.children('#msgid').val('');
                request_configure.children('.regular-text').val('');
                request_configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Add");

                e.preventDefault();
            });
        }
    }    
})
.directive('cancelRequestAdd', function() {
    return {
        restrict: 'A' 
      , link: function(scope, element, attr, ctrl) {
            $(element).bind('click', function(e) {
                var request_configure = $('.modal-configure');
                request_configure.dialog("close");
                e.preventDefault();
            });
        }
    }     
})
.directive('execRequestItem', function(MessageService) {
    return { 
        restrict: 'A' 
      , link: function(scope, element, attr, ctrl) {
            $(element).bind('click', function(e) {
                var request_configure = $('.modal-configure');
                var msgid  = request_configure.children('#msgid').val();
                var text = request_configure.children('.regular-text').val();
                
                //if msgid present means we're editing
                if(text.length == 0) { 
                    alert("This field cannot be blank.");
                } else { 
                    if(msgid || msgid.length > 0) {
                        var msg_obj = {'type': 'rqs', 'msg': text, 'id': msgid}
                        MessageService.update(msg_obj);

                        var a_msg = $("a#"+msgid);
                        a_msg.attr('req-text', MessageService.editdata.text);
                        a_msg.attr('id', MessageService.editdata.id);
                        a_msg.html(MessageService.editdata.short_text);
                    } else { 
                    //else we're adding new message
                        MessageService.save({'type': 'rqs', 'msg': text});
                    }
                    request_configure.dialog("close"); 
                }
                e.preventDefault();
            });
        }
    }     
})

//dialog form init
$('.request-dialog').dialog({
    autoOpen: false  
  , height: 618
  , width: 672 
  , modal: true
});
