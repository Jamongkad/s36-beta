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
           console.log($(element).children());

           var process = function(e) {
               e.stopImmediatePropagation();
               alert("mathew");
               return false;
           };

           $(element).children().click(process);
           $(element).click(process);
        }
    }    
    
})
