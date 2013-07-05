angular.module('feedbackcontrol', [])
.directive('transform', function(FeedbackSignal) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var currentUrl = window.location.pathname;
                var me = $(element); 
                var data = FeedbackSignal.data;

                if(currentUrl.match(/inbox\/all|deleted/g)) { 
                    if(data.id.length > 0) { 
                        hide_the_children(me);     
                        $(".checky-box-container").show();
                    }
                }

                if(currentUrl.match(/published/g)) { 

                    if(me.attr('return-policy') == 1) { 
                        hide_the_children(me);
                        $(".checky-box-container").show();
                    }

                    if(data.status == "feature") {
                        var state = { 
                            activate: {'background-position': '-64px -31px'}
                          , deactivate_sibling: {'background-position': '-32px 0px'}
                          , activation_color: {'background-color': '#ffffe0'} 
                          , state_change_inbox: '{"status": "inbox", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "feature"}'
                          , state_change: '{"status": "publish", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "publish"}'
                          , present_status: "feature"
                        }
                        published_state(me, '.publish', 'publish feedback', state);
                    }

                    if(data.status == "publish") {
                        var state = {
                            activate: {'background-position': '-32px -31px'}
                          , deactivate_sibling: {'background-position': '-64px 0px'}
                          , activation_color: {'background-color': '#fff'} 
                          , state_change_inbox: '{"status": "inbox", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "publish"}' 
                          , state_change: '{"status": "feature", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "feature"}'
                          , present_status: "publish"
                        } 
                        published_state(me, '.feature', 'feature feedback', state);
                    }

                    if(data.status == "delete" || data.status == "fileas") {
                        hide_the_children(me);
                        $(".checky-box-container").show();
                    }

                } 
                
                if(currentUrl.match(/filed/g)) { 

                    var data_status = data.status;

                    if(data_status == "publish" || data_status == "feature" || data_status == "delete") { 
                        hide_the_children(me);     
                        $(".checky-box-container").show();
                    }

                    if(data_status == "fileas") {
                        $(me).parents(".dashboard-feedback")
                               .children("div.feedback-contents")
                               .children(".responsive-padding")
                               .children(".feedback-details")
                               .children(".filed")
                               .html($(me).text())
                    }

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

                    var checkbox = $(".feed-checkbox[value=" + FeedbackSignal.data.id + "]");

                    if(checkbox.is(":checked")) {
                        checkbox.click();     
                    }
                }

                if($(".sorter-checkbox").is(":checked")) {
                    $(".sorter-checkbox").click(); 
                }

                if($('.feed-checkbox').is(":checked")) {
                    $('.feed-checkbox').prop("checked", false);
                }

                $(".dashboard-feedback").css({'background-color': '#FFF'});
               
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
          , status_type: "=type"
        }
      , link: function(scope, element, attrs) {
            $(element).bind('change', function() {
                console.log($(this).val())
                console.log(scope.feedid)
                console.log(scope.status_type)
                //FeedbackService.inline_change($(this).val(), scope.feedid, 'status');
            })
        }
    }    
})
/*
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
*/
.directive('deleteBlock', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                $(this).parents('.custom-att').fadeOut(400, function() {
                     var new_uploaded_images = new Array;
                     var new_attached_link;

                     var div = $(this).parents('.uploaded-images-and-links');
                     var images = div.find('.uploaded_image');
                     var media_attachment = div.find('.attached_link');
                      
                     var remove_image = {
                        'small_url'    :$(this).find('.small-image-url').val(),
                        'medium_url'   :$(this).find('.medium-image-url').val(),
                        'large_url'    :$(this).find('.large-image-url').val()
                     }

                    if(images.length > 0){   
                        var us = images.not(":hidden"); 
                        for(var i=0; i < us.length; i++) {
                            new_uploaded_images.push({
                                'name': $(us[i]).find('.image-name').val() 
                            });
                        }
                    }

                    if(!media_attachment.is(":hidden")) {
                        new_attached_link = {
                            title           : media_attachment.find('.link-title').val(),
                            description     : media_attachment.find('.link-description').val(),
                            image           : media_attachment.find('.link-image').val(),
                            url             : media_attachment.find('.link-url').val(),
                            video           : media_attachment.find('.link-video').val(),
                        } 
                    }

                    var remaining = {
                        uploaded_images : new_uploaded_images
                      , attached_link   : new_attached_link
                    }

                    var attachment_data = {
                        feedbackId      : div.find('.attachment_feedback_id').val()
                      , attachments     : remaining
                      , remove_image    : remove_image
                    } 
                     
                    //place this in service you lazy bastard!
                    $.ajax({
                        type: "POST"
                      , url: "/inbox/update_feedback_attachment"
                      , dataType: "json"
                      , data: attachment_data                
                    });                
                });
                e.preventDefault();
            })
        }
    }    
})
.directive('flag', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                var policy = $(this).attr("return-policy");
                if(policy == 1) {
                    $(this).removeAttr("style");
                    $(this).attr("return-policy", 0);
                } else { 
                    $(this).attr("style", "background-position: -194px -31px");
                    $(this).attr("return-policy", 1);
                }
                e.preventDefault();
            });
        }
    }    
})

function published_state(obj, sibling_id, msg, state) { 
    //kill me....
    obj.parents('.dashboard-feedback').css(state.activation_color);
    obj.css(state.activate);
    obj.children('.action-tooltip').children('span').html("Return to Inbox");
    obj.siblings(sibling_id).css(state.deactivate_sibling);
    obj.siblings(sibling_id).children('.action-tooltip').children('span').html(msg);
    obj.siblings(sibling_id).attr('return-policy', 0);
    obj.siblings(sibling_id).attr('data-feed', state.state_change);
    obj.attr('return-policy', 1);
    obj.attr('data-feed', state.state_change_inbox);

    var origin_cat_data = obj.siblings('.save')
                               .children('div.the-categories-menu')
                               .children('.the-categories-menu-content')
                               .children(".the-categories")
                               .children(".grids")
                               .children('li')
                               .children('a');

    for(var i=0;i<origin_cat_data.length;i++) {
        var cat = $(origin_cat_data[i]);

        var feed = $.parseJSON(cat.attr('data-feed'));
        feed.status = "fileas";
        feed.origin = state.present_status

        var repackaged_json = JSON.stringify(feed); 
        cat.attr('data-feed', repackaged_json);
    }
}

function hide_the_children(obj) { 
    obj.parents('.dashboard-feedback').hide();
    var child_count = obj.parents('.feedback-group').children('.dashboard-feedback:visible');
    if(child_count.length == 0) {
        obj.parents('.feedback-group').hide();
    }      
}
