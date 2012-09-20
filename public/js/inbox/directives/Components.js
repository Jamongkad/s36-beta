angular.module('Components', [])
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<h3>EMAIL SETTINGS</h3>'
    }  
});
.directive('msgSel', function() {
    var msgsel_fn;

    msgsel_fn = function(scope, element, attrs) {
        console.log(element);
    }

    return {
        restrict: 'E'     
      , link: msgsel_fn
    }  
})
