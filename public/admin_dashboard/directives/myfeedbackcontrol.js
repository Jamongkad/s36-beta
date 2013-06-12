angular.module('feedbackcontrol', [])
.directive('feature', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function($scope, element, attrs) {
            var id = FeedbackControlService.get_id();
            $(element).bind('click', function(e) { 
                console.log(id);
                console.log("Feature Directive");
            });
        }
    } 
});
