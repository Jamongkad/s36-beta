angular.module('feedbackcontrol', [])
.directive('feature', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                console.log($(element).parents('.dashboard-feedback'));
                console.log("Feature Directive");
            });
        }
    } 
});
