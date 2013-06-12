angular.module('feedbackcontrol', [])
.directive('feature', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function($scope, element, attrs) {
            $(element).bind('click', function(e) { 
                console.log(FeedbackControlService.get_id());
                console.log("Feature Directive");
            });
        }
    } 
});
