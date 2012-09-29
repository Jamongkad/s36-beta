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

        $(element).bind('click', function(e) {
            /* 
            if( validate_email($('#recipient-email').val()) ) {
                go = true; 
            } else { 
                go = false;
            }
            */

            $.each($("input[type=text], textarea[name=message]", me), function(index, value) {

                var elem = $(value);
                  
                if( elem.val() == 0 ) {
                     elem.css({'border': '1px solid red'}); 
                     go = false;
                }  else { 
                     elem.css({'border': '1px solid #CCCCCC'}); 
                     go = true;
                }
                e.preventDefault();
            });

            
            var email = $('#recipient-email');
            if(validate_email(email.val())) { 
                go = true;
                email.css({'border': '1px solid #CCCCCC'});
            } else { 
                go = false;
                email.css({'border': '1px solid red '});
            }

            console.log(go);
             
            /*
            if(go) { 
                me.ajaxSubmit({
                    success: function(data) {
                        alert("Your request has been sent!");
                        me.clearForm();
                        $('.request-dialog').dialog('close');
                    }
                });
            }
            */

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
