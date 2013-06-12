angular.module('feedbackcontrol', [])
.directive('feature', function() {
    return {
        restrict: 'A'     
      , scope: {
            feedid: "=feedid"    
        }
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                console.log("Feature Directive: " + scope.feedid);
                console.log(scope);
            });
        }
    } 
});
