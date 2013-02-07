angular.module('feedback', [])
.directive('feedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback;

            if(feedback.msg) {
                $(element).html("<sup class='count'>" + feedback.msg + "</sup>");
            }   

            console.log($(location).attr('href'))
            console.log(window.location.pathname === '/inbox/all');

        }
    }    
})
