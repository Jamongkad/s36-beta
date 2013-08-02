angular.module('feedback', [])
.directive('feedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback;
            var type = $(this).attr("show");
             
            if(feedback) {
                if(type == 'msg') { 
                    if(feedback.msg) {
                        console.log("Mathew");
                        $(element).html("<sup class='count'>" + feedback.msg + "</sup>");
                    }   
                }

                if(type == 'msg_ap') { 
                    if(feedback.msg_ap) {
                        console.log("Wong");
                        $(element).html("<sup class='count'>" + feedback.msg_ap + "</sup>");
                    }   
                }

                if(type == 'msg_topbar') { 
                    if(feedback.msg) {
                        console.log("Tall");
                        $(element).html("You have <sup class='count'>" + feedback.msg + "</sup> new feedback!");
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
