angular.module('feedbackcontrol', [])
.directive('feature', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function($scope, element, attrs) {
            $(element).bind('click', function(e) { 
                console.log(FeedbackControlService.get_id());
                console.log($scope.feedid);
                console.log("Feature Directive");
            });
        }
    } 
});
