angular.module('feedback', [])
.directive('feedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback;
            $(element).html("<sup class='count'>" + feedback.msg + "</sup>");
          /*
            $(element).bind('mouseover', function(e) {
                console.log("Pwet"); 
            });
            FeedbackService.get_feedback_count();

            if(feedback.checked) {
                $(element).html();     
            }
           */ 
        }
    }    
})
