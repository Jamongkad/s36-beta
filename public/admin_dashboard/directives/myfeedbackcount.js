angular.module('feedback', [])
.directive('feedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , scope: {
            type: "=show"    
        }
      , link: function(scope, element, attrs) {
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback;
            var type = scope.type;
            console.log(type);
            
            if(feedback) {
                if(type == 'msg') { 
                    if(feedback.msg) {
                        $(element).html("<sup class='count'>" + feedback.msg + "</sup>");
                    }   
                }

                if(type == 'msg_ap') { 
                    if(feedback.msg_ap) {
                        $(element).html("<sup class='count'>" + feedback.msg_ap + "</sup>");
                    }   
                }
            } else { 
                $(element).html("");
            }
        }
    }    
})
.directive('inboxclick', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
 
           $(element).click(function(e) {
               var type = $(this).attr('show');
               FeedbackService.set_inbox_as_read(type);
               e.preventDefault();
           });
        }
    }        
})
