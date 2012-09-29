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
                return error_msg.html("valid email required");
                email.css({'border': '1px solid red '});
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
    }
    
})

//dialog form init
$('.request-dialog').dialog({
    autoOpen: false  
  , height: 539
  , width: 700 
  , modal: true
});

function validate_email(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email); 
};

function validate(elem) {    
    if( elem.val() == 0 ) {
        elem.css({'border': '1px solid red'}); 
        return true;
        //error_msg.css({"background": "#ffa801"});
        //go = false;
    }  else { 
        elem.css({'border': '1px solid #CCCCCC'}); 
        return false;
        //error_msg.css({"background": "#fff"});
        //error_msg.hide();
        //go = true;
    }
}
