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
                var textarea = $(this).parents('td').children('textarea');              
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
                var request_configure = $('.request-configure');
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
                var msgid = $(this).attr('id');
                var request_configure = $('.request-configure');

                request_configure.dialog("open");
                request_configure.children('#msgid').val(msgid);
                request_configure.children('.regular-text').val('');
                request_configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Add");

                e.preventDefault();
            });
        }
    }    
})
.directive('requestConfigure', function() {
    return {
        restrict: 'C' 
      , controller: function($scope, $element, $rootScope) {
            $scope.name = "Request Message";
        }
    }    
})
.directive('cancelRequestAdd', function() {
    return {
        require: '^requestConfigure'
      , restrict: 'A' 
      , link: function(scope, element, attr, ctrl) {
            $(element).bind('click', function(e) {
                var request_configure = $('.request-configure');
                request_configure.dialog("close");
                e.preventDefault();
            });
        }
    }     
})
.directive('execRequestItem', function(MessageService) {
    return {
        require: '^requestConfigure'
      , restrict: 'A' 
      , link: function(scope, element, attr, ctrl) {
            $(element).bind('click', function(e) {
                var request_configure = $('.request-configure');
                var msgid  = request_configure.children('#msgid').val();
                var text = request_configure.children('.regular-text').val();
                
                //if msgid present means we're editing
                if(msgid || msgid.length > 0) {
                    MessageService.edit_request_message({
                        'text': text
                      , 'msgid': msgid
                    });
                    $("a#"+msgid).attr('req-text', MessageService.editdata.text);
                    $("a#"+msgid).attr('id', MessageService.editdata.id);
                    $("a#"+msgid).html(MessageService.editdata.short_text);
                } else { 
                //else we're adding new message
                    MessageService.add_request_message(text);
                }

                request_configure.dialog("close");
 
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

$('.request-configure').dialog({
    autoOpen: false  
  , height: 110
  , width: 200 
  , modal: true
});
