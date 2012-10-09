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
                console.log($(this).attr('id'));
                e.preventDefault();
            });
        }
    }  
})

//dialog form init
$('.request-dialog').dialog({
    autoOpen: false  
  , height: 539
  , width: 700 
  , modal: true
});
