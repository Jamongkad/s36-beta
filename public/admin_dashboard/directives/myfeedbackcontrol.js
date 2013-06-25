angular.module('feedbackcontrol', [])
.directive('transform', function(FeedbackSignal) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var currentUrl = window.location.pathname;
                var me = $(element); 
                var data = FeedbackSignal.data;

                if(currentUrl.match(/published|contacts/g)) { 

                    if(me.attr('return-policy') == 1) { 
                        hide_the_children(me);
                        data.status = "inbox";
                        FeedbackSignal.current_state(data);
                    }

                    if(data.status == "feature") {
                        published_state(me, '.publish', 'Publish Feedback', {  activate: {'background-position': '-64px -31px'}
                                                                             , deactivate_sibling: {'background-position': '-32px 0px'}
                                                                             , activation_color: {'background-color': '#FFFFE0'} });
                    }

                    if(data.status == "publish") {
                        published_state(me, '.feature', 'Feature Feedback', {  activate: {'background-position': '-32px -31px'}
                                                                             , deactivate_sibling: {'background-position': '-64px 0px'}
                                                                             , activation_color: {'background-color': '#FFF'} });
                    }
                } else { 
                    hide_the_children(me);
                }

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

function published_state(obj, sibling_id, msg, state) { 
    obj.parents('.dashboard-feedback').css(state.activation_color);
    obj.css(state.activate);
    obj.siblings(sibling_id).css(state.deactivate_sibling);
    obj.children('.action-tooltip').children('span').html("Return to Inbox");
    obj.siblings(sibling_id).children('.action-tooltip').children('span').html(msg);
    obj.siblings(sibling_id).attr('return-policy', 0);
    obj.attr('return-policy', 1);
}

function hide_the_children(obj) { 
    obj.parents('.dashboard-feedback').hide();
    var child_count = obj.parents('.feedback-group').children('.dashboard-feedback:visible');
    if(child_count.length == 0) {
        obj.parents('.feedback-group').hide();
    }      

    $(".checky-box-container").show();
}
