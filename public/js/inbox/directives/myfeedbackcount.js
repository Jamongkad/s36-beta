angular.module('feedback', [])
.directive('feedbackcount', function() {
    return {
        restrict: 'A'     
      , template: '{{score}}'
      , link: function(scope, element, attrs) {
          scope.score = 10;
          /*
            $(element).bind('mouseover', function(e) {
                console.log("Pwet"); 
            });
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback_count;

            if(feedback.checked) {
                $(element).html("<sup class='count'>" + feedback.feedback_count + "</sup>");     
            }
           */ 
        }
    }    
})
