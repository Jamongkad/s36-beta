angular.module('request', [])
.directive('myRequest', function() {
    return function($scope, element, attr) {
        $(element).bind('click', function(e) {
            $('.request-dialog').fadeIn();
            $('div#request-feedback').draggable();
            $('div#request-feedback.lightbox').show();
            e.preventDefault();
        });
    }
})
.directive('myRequestClose', function() {
    return function($scope, element, attr) {
        $(element).bind('click', function(e) {

            var choice = $(this).attr('value');                  

            $scope.$apply(function() {
                $scope.template = { name: "request_form", url: "/feedback/load_request_form" }
            })      

            if(choice == 'Cancel') { 
                $('.request-dialog').fadeOut();
                $('div#request-feedback').draggable("destroy");
                $("#cancel_button").val("Cancel");
            }

            if(choice == 'Back') {
                $("#cancel_button").val("Cancel");
            }

            $("#send_button").val("Send");

            e.preventDefault();
        })
    } 
})
.directive('myRequestSend', function() {
    return function(scope, element, attr) {

        $(element).bind('click', function(e) {
            var choice = $(this).attr('value');                  
            if(choice == 'Send') {
                $(element).parents('#request-form').validate({
                    submitHandler: function(form) {
                        $(form).ajaxSubmit({ 
                            success: function(data) {
                                alert("Your request has been sent!");
                                $(form).clearForm();
                                $('div#request-feedback').draggable("destroy");
                                $(element).parents('.request-dialog').fadeOut(); 
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

            if(choice == 'Save') {
                console.log('saving');
            }

            e.preventDefault();
        })

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
                $("#send_button").val("Save");
                $("#cancel_button").val("Back");
                /*
                var msgid = $(this).attr('id');
                var configure = $('.modal-configure');
                var req_text = $(this).parents('span').siblings('a').attr('req-text');

                configure.dialog({ zIndex: 100001 });
                configure.dialog("open"); 
                configure.children('#msgid').val(msgid);
                configure.children('.regular-text').val(req_text);
                configure.children('#msgtype').val("rqs");
                configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Update");
                */
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
                $("#send_button").val("Save");
                $("#cancel_button").val("Back");
                /*
                var configure = $('.modal-configure');

                configure.dialog({ zIndex: 100001 });
                configure.dialog("open");
                configure.children('#msgid').val('');
                configure.children('.regular-text').val('');
                configure.children('#msgtype').val("rqs");
                configure.children('.add-msg-box-buttons').children('input[type=submit]').val("Add");
                */
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
                var configure = $('.modal-configure');
                configure.dialog("close");
                e.preventDefault();
            });
        }
    }     
})
