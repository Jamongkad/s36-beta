angular.module('feedback', [])
.directive('myFeedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('mouseover', function(e) {
                console.log("Pwet"); 
            });
            /*
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback_count;

            if(feedback.checked) {
                $(element).html("<sup class='count'>" + feedback.feedback_count + "</sup>");     
            }
            */ 
        }
    }    
})
.directive('kid', function() { 
    return {
        restrict: 'E'     
      , element: '<input type="text" />'
    }
})
