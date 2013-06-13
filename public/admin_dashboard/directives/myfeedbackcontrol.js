angular.module('feedbackcontrol', [])
.directive('feature', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                $(element).parents('.dashboard-feedback').fadeOut(500);
                console.log("Feature Directive");
            });
        }
    } 
});
