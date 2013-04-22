angular.module('reply', [])
.directive('myReply', function(MessageService) {    
    return {
        restrict: 'A'       
      , scope: {
            feedid: "=feedid"   
        }
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 

                var feedid = scope.feedid;

                MessageService.fetch_messages('msg');
                MessageService.register_reply_message();

                MessageService.get_replybody(feedid);
                MessageService.register_replybody();
                
                $('div#reply-to-user').draggable();
                $('div#reply-to-user.lightbox').show();
                $(".dialog-form[feedid="+feedid+"]").show();
                e.preventDefault();

            });
        }
    } 
})
.directive('replyCancel', function(){
    return function($scope, element, attrs){
        $(element).bind('click', function(e) {

            var choice = $(this).attr('value');
              
            $scope.$apply(function() {
                $scope.template = { name: "reply_form", url: "/feedback/load_reply_form" };     
            });

            if(choice == 'Cancel') { 
                $(this).parents('form textarea[name=bcc] textarea[name=message]').clearFields(); 
                $(this).parents(".dialog-form").fadeOut();
                $('div#reply-to-user').draggable("destroy");
                $("#cancel_button").val("Cancel");
            }

            if(choice == 'Back') {
                $("#cancel_button").val("Cancel");
            }

            $("#send_button").val("Send");
 
            e.preventDefault();
        });
    }
})
.directive('replySend', function(MessageService) {
    return function(scope, element, attrs) {
        $(element).bind('click', function(e) {
        
            var choice = $(this).attr('value');

            if(choice == 'Save') { 
                console.log(MessageService.msgdata);
                MessageService.save(MessageService.msgdata);
            }

            if(choice == 'Send') {
                console.log("Sending Email");
            }
            e.preventDefault();
        });
        /*
        $(element).parents('form').validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function() {
                        alert("Your reply has been sent!");
                        $(element).parents(".dialog-form").fadeOut();
                        $('div#reply-to-user').draggable("destroy");
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
        */
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
      , link: function($scope, element, attrs) {
            $(element).bind("click", function(e) { 
                $("#send_button").val("Save");
                $("#cancel_button").val("Back");
                e.preventDefault();
            }) 
        }
    }     
})
.directive('configureReply', function() { 
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                $("#send_button").val("Save");
                $("#cancel_button").val("Back");
                /*
                var configure = $('.modal-configure');
                configure.dialog({ zIndex: 100001 });
                configure.dialog('open');
                configure.children('.regular-text').val("");
                configure.children('#msgid').val("");
                configure.children('#msgtype').val("msg");
                configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Add");
                */
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
.directive('goback', function() {
    return {
        restrict: 'A'
      , link: function(scope, element, attr) {
            $(element).bind("click", function(e) { 
                $("#send_button").val("Send");
            })
        }
    }        
})
.directive('bcc', function() {
    return {  
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                console.log('clicked');
                var feedid = $(this).attr('feedid');
                var email = $(this).attr('email');
                var textarea = $('textarea[name=bcc][feedid=' + feedid + ']');
                textarea.val(textarea.val() + email + ',');
                e.preventDefault();
            });

        }
    }    
})
