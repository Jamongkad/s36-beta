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
        $(element).bind('click', function(e) {
            me = $("#request-form");
            me.ajaxSubmit({
                success: function(data) {
                    alert("Your request has been sent!");
                    me.clearForm();
                    $('.request-dialog').dialog('close');
                }
            });
            e.preventDefault();
        })
    }
    
})

$('.request-dialog').dialog({
    autoOpen: false  
  , height: 459
  , width: 700 
  , modal: true
});
