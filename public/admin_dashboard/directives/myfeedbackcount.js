angular.module('feedback', [])
.directive('feedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback;
            var type = $(element).attr("show");
             
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

                if(type == 'msg_topbar') { 
                    if(feedback.msg) {
                        var link = "<a href='/inbox/all' id='click-topbar'>You have <sup class='count-topbar'>" + feedback.msg + "</sup> new feedback!</a>"  
                        $(element).html(link);
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
               console.log(type);
               //FeedbackService.set_inbox_as_read(type);
               e.preventDefault();
           });
        }
    }        
})

$("#click-topbar").bind("click", function(e) {
    console.log("Mathew");
    e.preventDefault(); 
})
