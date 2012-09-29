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

        $(element).bind('click', function(e) {

            if($("input[type=text], textarea[name=message]", me).val() == 0) { 
                alert("All input fields are required!");
                e.preventDefault(); 
            } else {
                me.ajaxSubmit({
                    success: function(data) {
                        alert("Your request has been sent!");
                        me.clearForm();
                        $('.request-dialog').dialog('close');
                    }
                });
                e.preventDefault(); 
            }
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
