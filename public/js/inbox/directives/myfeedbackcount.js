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
        }
    }    
})
.directive('inboxclick', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {

           var process = function(e) {
               e.stopImmediatePropagation();
               FeedbackService.set_inbox_as_read();
               return false;
           };

           $(element).children().click(process);
           $(element).click(process);
        }
    }    
    
})
