angular.module('feedback', [])
.directive('feedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback;
            $(element).html("<sup class='count'>" + feedback.msg + "</sup>");
            $(element).bind('click', function(e) {
                e.preventDefault();
            });
        }
    }    
})
