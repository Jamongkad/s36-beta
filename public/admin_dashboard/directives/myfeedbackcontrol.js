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
                    }

                    if(data.status != "fileas") { 
                        if(data.status == "feature") {
                            var state = { 
                                activate: {'background-position': '-64px -31px'}
                              , deactivate_sibling: {'background-position': '-32px 0px'}
                              , activation_color: {'background-color': '#FFFFE0'} 
                              , state_change_inbox: '{"status": "inbox", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "publish"}'
                              , state_change: '{"status": "publish", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "publish"}'
                            }
                            published_state(me, '.publish', 'Publish Feedback', state);
                        }

                        if(data.status == "publish") {
                            var state = {
                                activate: {'background-position': '-32px -31px'}
                              , deactivate_sibling: {'background-position': '-64px 0px'}
                              , activation_color: {'background-color': '#FFF'} 
                              , state_change_inbox: '{"status": "inbox", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "publish"}' 
                              , state_change: '{"status": "feature", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "publish"}'
                            } 
                            published_state(me, '.feature', 'Feature Feedback', state);
                        }
                    } else { 
                        hide_the_children(me);
                    }

                } else if(currentUrl.match(/filed/g)) { 

                    var data_status = data.status;

                    if(data_status == "publish" || data_status == "feature" || data_status == "delete") { 
                        hide_the_children(me);     
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
.directive('statuschange', function(FeedbackService) {
    return {
        restrict: 'A'     
      , scope: {
            feedid: "=feedid"   
        }
      , link: function(scope, element, attrs) {
            $(element).bind('change', function() {
                FeedbackService.inline_change($(this).val(), scope.feedid, 'status');
            })
        }
    }    
})
.directive('prioritychange', function(FeedbackService) {
    return {
        restrict: 'A'     
      , scope: {
            feedid: "=feedid"   
        }
      , link: function(scope, element, attrs) {
            $(element).bind('change', function() {
                FeedbackService.inline_change($(this).val(), scope.feedid, 'priority');
            })
        }
    }    
})
.directive('deleteBlock', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                $(this).parents('.custom-att').fadeOut(400, function() {
                     var div = $(this).parents('.uploaded-images-and-links');
                     $(this).remove();

                     var remove_images = {
                        'small_url'    :$(this).find('.small-image-url').val(),
                        'medium_url'   :$(this).find('.medium-image-url').val(),
                        'large_url'    :$(this).find('.large-image-url').val()
                     }

                    var attachments = new Array;
                    if(div.find('.uploaded_image').length>0){
                        var new_uploaded_images = new Array;
                        div.find('.the-thumb').each(function(){
                            new_uploaded_images.push({
                                'name'    :$(this).find('.image-name').val(),
                            });
                        });
                    }

                    if(div.find('.attached_link').length > 0){
                        var new_attached_link = {
                            title           : div.find('.link-title').val(),
                            description     : div.find('.link-description').val(),
                            image           : div.find('.link-image').val(),
                            url             : div.find('.link-url').val(),
                            video           : div.find('.link-video').val(),
                        }
                    };

                    var remaining = {
                        uploaded_images : new_uploaded_images
                      , attached_link   : new_attached_link
                    }

                    var data = {
                        feedbackId      : div.find('.attachment_feedback_id').val()
                      , attachments     : remaining
                      , remove_images   : remove_images
                    }

                    console.log(div.find('.attached_link'));
                    console.log(div.find('.uploaded_image'));
                    console.log(data);
                });
                /*
                 $(this).parent().fadeOut(400, function() {
                     var div = $(this).parent('.uploaded-images-and-links');            
                     //$(this).remove();

                     var remove_images = {
                        'small_url'    :$(this).find('.small-image-url').val(),
                        'medium_url'   :$(this).find('.medium-image-url').val(),
                        'large_url'    :$(this).find('.large-image-url').val()
                     }
                     
                    var attachments = new Array;
                    if(div.find('.uploaded_image').length>0){
                        var new_uploaded_images = new Array;
                        div.find('.the-thumb').each(function(){
                            new_uploaded_images.push({
                                'name'    :$(this).find('.image-name').val(),
                            });
                        });
                    }

                    if(div.find('.attached_link').length > 0){
                        var new_attached_link = {
                            title           : div.find('.link-title').val(),
                            description     : div.find('.link-description').val(),
                            image           : div.find('.link-image').val(),
                            url             : div.find('.link-url').val(),
                            video           : div.find('.link-video').val(),
                        }
                    };

                    var remaining = {
                        uploaded_images : new_uploaded_images,
                        attached_link   : new_attached_link
                    }

                    console.log(remaining);
                    console.log(remove_images);
                    console.log(div.find('.attachment_feedback_id').val()); 
                });
                */
                e.preventDefault();
            });
        }
    }    
})

function published_state(obj, sibling_id, msg, state) { 
    obj.parents('.dashboard-feedback').css(state.activation_color);
    obj.css(state.activate);
    obj.children('.action-tooltip').children('span').html("Return to Inbox");
    obj.siblings(sibling_id).css(state.deactivate_sibling);
    obj.siblings(sibling_id).children('.action-tooltip').children('span').html(msg);
    obj.siblings(sibling_id).attr('return-policy', 0);
    obj.siblings(sibling_id).attr('data-feed', state.state_change);
    obj.attr('return-policy', 1);
    obj.attr('data-feed', state.state_change_inbox);
}

function hide_the_children(obj) { 
    obj.parents('.dashboard-feedback').hide();
    var child_count = obj.parents('.feedback-group').children('.dashboard-feedback:visible');
    if(child_count.length == 0) {
        obj.parents('.feedback-group').hide();
    }      

    $(".checky-box-container").show();
}
