angular.module('Components', [])
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<h3>EMAIL SETTINGS</h3>'
    }  
})
.directive('msgSel', function() {
    var msgsel_fn;

    msgsel_fn = function(scope, element, attrs) {
        $(element).bind('click', function(e) {
            alert("mathew");
        });
    }

    return {
        restrict: 'E'     
      , link: msgsel_fn
    }  
})
