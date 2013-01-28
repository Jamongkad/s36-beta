angular.module('feedback', [])
.directive('myFeedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {

            FeedbackService.get_feedback_count();
            var feedback_counts = FeedbackService.feedback_count;

            console.log(feedback_counts);

            $(element).html("mathew");
        }
    }    
})
