angular.module('feedback', [])
.directive('myFeedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).html(FeedbackService.feedback_count.feedback_count);
        }
    }    
})
