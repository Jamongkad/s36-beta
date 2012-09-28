angular.module('request', [])
.directive('myRequest', function() {
    return function(scope, element, attr) {
        $(element).bind('click', function(e) {
            $('.request-dialog').dialog('open');
            e.preventDefault();
        })
    }
})

$('.request-dialog').dialog({
    autoOpen: false  
  , height: 470
  , width: 700 
  , modal: true
});
