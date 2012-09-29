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
        $(element).parents('form').validate({
            submitHandler: function(form) {
                //$(form).ajaxSubmit()
                console.log(form);
            }
          , errorElement: "em"
          , rules: {
                first_name: {
                    required: true     
                }    
              , last_name: {  
                    required: true     
                }
              , message: {
                    required: true   
                }
              , email: {
                    required: true   
                  , email: true 
                }
            }
        });
        /*       
        var me = $("#request-form");
        var go;
        var error_msg = $(".reply-box-error");

        error_msg.css({"background": "#fff"});

        $(element).bind('click', function(e) {
            var fname = $("#recipient-fname");
            var lname = $("#recipient-lname");
            var message = $("#recipient-message");
            var email = $("#recipient-email");

            if( validate(fname) ) {  
                go = false;
                fname.focus();
                return error_msg.html("first name required.");
            } else {
                go = true;
            }

            if( validate(lname) ) {
                go = false;
                lname.focus();
                return error_msg.html("last name required.");
            } else {
                go = true;     
            }

            if( validate(message) ) {
                go = false;
                message.focus();
                return error_msg.html("email message required.");
            } else {
                go = true;     
            }

            if( validate(email) ) { 
                go = false;
                email.focus();
                return error_msg.html("email required.");
            } else {
                go = true; 
            }

            if(validate_email(email.val())) { 
                go = true;
                email.css({'border': '1px solid #CCCCCC'});
            } else { 
                go = false;
                email.focus();
                email.css({'border': '1px solid red '});
                return error_msg.html("valid email required");
            }

            if(go) { 
                me.ajaxSubmit({
                    success: function(data) {
                        alert("Your request has been sent!");
                        me.clearForm();
                        $('.request-dialog').dialog('close');
                    }
                });
            }

            e.preventDefault(); 
        })
        */
    } 
})

//dialog form init
$('.request-dialog').dialog({
    autoOpen: false  
  , height: 539
  , width: 700 
  , modal: true
});
