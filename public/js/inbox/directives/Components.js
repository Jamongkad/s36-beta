angular.module('Components', [])
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<h3>EMAIL SETTINGS</h3>'
    }  
})
.directive('msgsel', function() {
    var msgsel_fn;

    msgsel_fn = function(scope, element, attrs) {
        console.log(element);
        $(element).bind('click', function(e) {
            alert("mathew");
        });
    }

    return {
        restrict: 'C'     
      , link: msgsel_fn
    }  
})
