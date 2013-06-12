angular.module('feedbackcontrol', [])
.directive('feature', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                console.log("Feature Directive:");
                console.log(scope);
            });
        }
    } 
});
