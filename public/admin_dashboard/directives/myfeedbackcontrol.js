angular.module('feedbackcontrol', [])
.directive('transform', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var me = $(element)

                me.parents('.dashboard-feedback').hide();
                var child_count = me.parents('.feedback-group').children('.dashboard-feedback:visible');
                if(child_count.length == 0) {
                    me.parents('.feedback-group').hide();
                }      

                $(".checky-box-container").show();
                e.preventDefault();
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
                if (FeedbackSignal.data.id instanceof Array) {
                    for(var i=0; i < FeedbackSignal.data.id.length ; i++)     { 
                        var feedback = $(".dashboard-feedback[feedback=" + FeedbackSignal.data.id[i] + "]");
                        feedback.show();
                        $(feedback).parents('.feedback-group').show();
                        $(".feed-checkbox[value=" + FeedbackSignal.data.id[i] + "]").click();
                    }
                } else { 
                    var feedback = $(".dashboard-feedback[feedback=" + FeedbackSignal.data.id + "]"); 
                    feedback.show();
                    $(feedback).parents('.feedback-group').show();
                }

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
.directive('feedcheckbox', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            var checkbox = $(element);

            checkbox.bind('change', function() {
                if(checkbox.is(":checked")) { 
                    checkbox.parents('.dashboard-feedback').css({'background-color': '#F7F7F7'});     
                } else {
                    checkbox.parents('.dashboard-feedback').css({'background-color': '#FFF'});     
                }  
            });
            
        }
    }    
    
})
