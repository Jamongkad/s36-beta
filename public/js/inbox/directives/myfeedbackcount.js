angular.module('feedback', [])
.directive('myFeedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {

            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback_count;

            console.log(feedback);
            if(feedback.checked) {
                $(element).html("<sup class='count'>" + feedback.feedback_count + "</sup>");     
            }
           
        }
    }    
})
