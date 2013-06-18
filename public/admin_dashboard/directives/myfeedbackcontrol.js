angular.module('feedbackcontrol', [])
.directive('transform', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var me = $(element)
                me.parents('.dashboard-feedback').fadeOut(500, function() {

                    var child_count = $(me).parents('.feedback-group').children('.dashboard-feedback:visible');
                    if(child_count.length == 0) {
                        $(me).parents('.feedback-group').fadeOut(500);
                    }      

                }); 
                $(".checky-box-container").show();
            });
        } 
    }    
})
.directive('undo', function(FeedbackSignal) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind("click", function(e) {
                $(".checky-box-container").hide();
                console.log("From Directive: " + FeedbackSignal.feed_id);
                e.preventDefault();
            });
        }
    }    
})
.directive('close', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind("click", function(e) {
                $(".checky-box-container").hide();
                e.preventDefault();
            }); 
        }
    }    
})
