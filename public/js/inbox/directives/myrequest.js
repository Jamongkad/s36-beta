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

        $(element).bind('click', function(e) {
            /*
            var first_name = $("input[name=first_name]");
            if( first_name.val() == 0 ) {
                 first_name.css({'border': '1px solid red'}); 
                 go = false;
            }  else { 
                 first_name.css({'border': '1px solid #CCCCCC'}); 
                 go = true;
            }

            var last_name = $("input[name=last_name]");
            if( last_name.val() == 0 ) {
                 last_name.css({'border': '1px solid red'}); 
                 go = false;
            }  else { 
                 last_name.css({'border': '1px solid #CCCCCC'}); 
                 go = true;
            }

            var message = $("input[name=message]");
            if( messagej.val() == 0 ) {
                 messagej.css({'border': '1px solid red'}); 
                 go = false;
            }  else { 
                 messagej.css({'border': '1px solid #CCCCCC'}); 
                 go = true;
            }
            */
 
            validate($("input[name=first_name]"), go);
            validate($("input[name=last_name]"), go);
            validate($("textarea[name=message]"), go);

            var email = $("#recipient-email");
            if(validate_email(email.val()) && email.val() > 0) { 
                go = true;
                email.css({'border': '1px solid #CCCCCC'});
            } else { 
                go = false;
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
  , height: 459
  , width: 700 
  , modal: true
});

function validate_email(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email); 
};

function validate(elem, go) {
    
    if( elem.val() == 0 ) {
        elem.css({'border': '1px solid red'}); 
        go = false;
    }  else { 
        elem.css({'border': '1px solid #CCCCCC'}); 
        go = true;
    }

    return go;
}
