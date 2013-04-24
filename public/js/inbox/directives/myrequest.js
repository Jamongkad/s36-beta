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
.directive('myRequestClose', function(MessageService) {
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

            MessageService.fetch_messages('rqs');     
            MessageService.register_request_message();

            e.preventDefault();
        })
    } 
})
.directive('requestemail', function() {
    return function(scope, element, attrs) {
        $(element).bind('keyup', function() {
            console.log($(this).val());
            if(validateEmail($.trim($(this).val()))) {
                $(this).removeAttr('style');
            } else {
                $(this).css({'border': '1px solid red'});               
                $("#invalid_email").remove();
                $(this).after('<p id="invalid_email">invalid email</p>');
            }
        })
    }
})
.directive('myRequestSend', function(MessageService) {
    return function($scope, element, attr) {

        $(element).bind('click', function(e) {
            var choice = $(this).attr('value');                  
            var validate = ['#first_name', '#last_name', '#recipient-email', '#recipient-message'];
            if(choice == 'Send') {
                var data = $('form#request-form').serializeForm();
                var validcount = [];
                for(var i=0; i<validate.length; i++) {
                    var me = validate[i];
                    if($(me).val() == "") {
                        $(me).css({'border': '1px solid red'});
                        console.log('push ' + me);
                        validcount.push(me);                        
                    } else { 
                        $(me).removeAttr('style'); 
                        console.log('pop ' + me);
                        removeA(validcount, me);
                    }   
                }

                if(validcount.length == 0)  {
                    console.log(data);              
                    MessageService.send_request_email(data, function() { 
                        alert("Your request has been sent!");
                        $('#first_namej').clearFields();
                        $('#last_name').clearFields();
                        $('#recipient-email').clearFields();
                        $('#recipient-message').clearFields();

                        $('div#request-feedback').draggable("destroy");
                        $(element).parents('.request-dialog').fadeOut(); 
                    })
                }
                
            }

            if(choice == 'Save') {
                console.log('saving');

                    if($('#mymessage').val() == "") {
                        $('#mymessage').css({
                            'border': '1px solid red'
                        })
                    } else {

                        $('#mymessage').removeAttr('style');

                        MessageService.save(MessageService.msgdata);

                        var msgtype = MessageService.msgdata.msgtype;
  
                        MessageService.fetch_messages(msgtype);     
                        MessageService.register_request_message();
                       
                        $scope.$apply(function() {
                            $scope.template = { name: "request_form", url: "/feedback/load_request_form" };     
                        });
                    }
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

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}
