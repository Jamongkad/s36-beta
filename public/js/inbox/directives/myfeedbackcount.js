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
.directive('inboxclick', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
           console.log($(element));
           $(element).click(function(e) {
               e.preventDefault();
           })
        }
    }    
    
})
