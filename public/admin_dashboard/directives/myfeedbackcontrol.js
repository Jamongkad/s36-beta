angular.module('feedbackcontrol', [])
.directive('transform', function(FeedbackSignal) {
    return {
        restrict: 'A'     
      , scope: {
            policy: "=returnPolicy"   
        }
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var currentUrl = window.location.pathname;
                var me = $(element); 
                var data = FeedbackSignal.data;

                console.log(scope.policy);

                if(currentUrl.match(/published|contacts/g)) { 
                    if(data.status == "feature") {
                        me.parents('.dashboard-feedback').css({'background-color': '#FFFFE0'});
                        me.css({'background-position': '-64px -31px'});
                        me.siblings('.publish').css({'background-position': '-32px 0px'})
                        me.children('.action-tooltip').children('span').html("Return to Inbox");
                        me.siblings('.publish').children('.action-tooltip').children('span').html("Publish Feedback");
                        console.log(me.attr('return-policy'));
                    }

                    if(data.status == "publish") {
                        me.parents('.dashboard-feedback').css({'background-color': '#FFF'});
                        me.css({'background-position': '-32px -31px'});
                        me.siblings('.feature').css({'background-position': '-64px 0px'});
                        me.children('.action-tooltip').children('span').html("Return to Inbox");
                        me.siblings('.feature').children('.action-tooltip').children('span').html("Feature Feedback");
                        console.log(me.attr('return-policy'));
                    }
                } 
                 
                /*
                me.parents('.dashboard-feedback').hide();
                var child_count = me.parents('.feedback-group').children('.dashboard-feedback:visible');
                if(child_count.length == 0) {
                    me.parents('.feedback-group').hide();
                }      

                $(".checky-box-container").show();
                */
                e.preventDefault();
            });
        } 
    }    
})
.directive('undo', function(FeedbackSignal, FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind("click", function(e) {
                $(".checky-box-container").hide();
                if (FeedbackSignal.data.id instanceof Array) {
                    for(var i=0; i < FeedbackSignal.data.id.length ; i++) { 
                        var feedback = $(".dashboard-feedback[feedback=" + FeedbackSignal.data.id[i] + "]");
                        feedback.show();
                        $(feedback).parents('.feedback-group').show(); 
                    }
                } else { 
                    var feedback = $(".dashboard-feedback[feedback=" + FeedbackSignal.data.id + "]"); 
                    feedback.show();
                    $(feedback).parents('.feedback-group').show();
                }

                FeedbackControlService.expunge();
                e.preventDefault();
            });
        }
    }    
})
.directive('close', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind("click", function(e) {
                $(".checky-box-container").hide();
                FeedbackControlService.expunge();
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
