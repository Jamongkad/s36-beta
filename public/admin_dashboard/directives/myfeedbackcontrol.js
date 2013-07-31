angular.module('feedbackcontrol', [])
.directive('transform', function(FeedbackSignal) {
    return {
        restrict: 'A'     
      , link: function($scope, element, attrs) {

            var currentUrl = window.location.pathname;

            $scope.$watch('checkFeedbackStatus', function() {
                $(element).bind('click', function(e) {   
                    var me = $(element); 
                    $scope.mystatus = FeedbackSignal.get_data(); 
                    var data = $scope.mystatus;

                    if(data.status == 'flag' || data.status == 'unflag') { 
                        var feed = $.parseJSON($(this).attr('data-feed')); 
                        var policy = $(this).attr("return-policy");
                        if(feed.status == "unflag") {
                            feed.status = "flag";
                            $(this).removeAttr("style");
                            var repackaged_json = JSON.stringify(feed); 
                            $(this).attr('data-feed', repackaged_json);
                        } else { 
                            feed.status = "unflag";
                            $(this).attr("style", "background-position: -194px -31px");
                            var repackaged_json = JSON.stringify(feed); 
                            $(this).attr('data-feed', repackaged_json);
                        } 
                        $(".checky-box-container").show();
                    } else {
                        if(currentUrl.match(/inbox\/all|deleted/g)) { 
                            if(data.id.length > 0) { 
                                hide_the_children(me);     
                                $(".checky-box-container").show();
                            }
                        }

                        if(currentUrl.match(/published/g)) { 

                            if(me.attr('return-policy') == 1) { 
                                if(data.origin == "publish") { 
                                    hide_the_children(me);
                                    $(".checky-box-container").show();
                                } else { 
                                    console.log("feature");
                                    var state = {
                                        activate: {'background-position': '-32px -31px'}
                                      , deactivate_sibling: {'background-position': '-64px 0px'}
                                      , activation_color: 'published'
                                      , state_change_inbox: '{"status": "unfeature", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "feature"}' 
                                      , state_change: '{"status": "feature", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "feature"}'
                                      , present_status: "publish"
                                    } 
                                    published_state(me, '.feature', 'Feature Feedback', state);
                                }
                            }

                            if(data.status == "feature") {
                                var state = { 
                                    activate: {'background-position': '-64px -31px'}
                                  , deactivate_sibling: {'background-position': '-32px 0px'}
                                  , activation_color: 'featured'
                                  , state_change_inbox: '{"status": "unfeature", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "feature"}'
                                  , state_change: '{"status": "publish", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "publish"}'
                                  , present_status: "feature"
                                }
                                published_state(me, '.publish', 'Publish Feedback', state);
                            }

                            if(data.status == "publish") {
                                var state = {
                                    activate: {'background-position': '-32px -31px'}
                                  , deactivate_sibling: {'background-position': '-64px 0px'}
                                  , activation_color: 'published'
                                  , state_change_inbox: '{"status": "inbox", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "publish"}' 
                                  , state_change: '{"status": "feature", "id": ' + data.id + ', "catid": ' + data.catid + ', "origin": "feature"}'
                                  , present_status: "publish"
                                } 
                                published_state(me, '.feature', 'Feature Feedback', state);
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
                    }

                    e.preventDefault();
                }); 
            });
        } 
    }    
})
.directive('undo', function(FeedbackSignal, FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function($scope, element, attrs) {
            var currentUrl = window.location.pathname;
            $scope.$watch('checkFeedbackStatus', function() {
                $(element).bind("click", function(e) {                 
                    $scope.mystatus = FeedbackSignal.get_data(); 
                    var data = $scope.mystatus;

                    $(".checky-box-container").hide();
                    if (data.id instanceof Array) {
                        for(var i=0; i < data.id.length ; i++) { 
                            var feedback = $(".dashboard-feedback[feedback=" + data.id[i] + "]");
     
                            feedback.show();
                            $(feedback).parents('.feedback-group').show();  
                            
                            if(currentUrl.match(/inbox\/all|deleted|published/g)) {
                                var catpicks = $(".dashboard-feedback[feedback=" + data.id[i] + "] li .cat-picks");      
                                catpicks.css({'background': '#598499'});
                            }
                        }
                    } else {  
                        var feedback = $(".dashboard-feedback[feedback=" + data.id + "]"); 
                       
                        feedback.show();
                        $(feedback).parents('.feedback-group').show();    
                        
                        if(currentUrl.match(/inbox\/all|deleted|published/g)) {
                            var catpicks = $(".dashboard-feedback[feedback=" + data.id + "] li .cat-picks");      
                            catpicks.css({'background': '#598499'});
                        }

                        var checkbox = $(".feed-checkbox[value=" + data.id + "]");

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
     
                    e.preventDefault();
                });
            })
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
            feedid: "@feedid"   
          , statustype: "@statustype"
        }
      , link: function(scope, element, attrs) {
            $(element).bind('change', function() {
                var status_class, value;
                var myvalue = $(this).val();
                if(scope.statustype == "status") {
                   status_class = ".status-line"; 
                   console.log(myvalue);
                   if(myvalue == "new") { value = "New"; }
                   if(myvalue == "inprogress") { value = "In Progress"; }
                   if(myvalue == "closed") { value = "Closed"; }
                } else { 
                   status_class = ".priority-line";
                   console.log(myvalue);
                   if(myvalue == 0) { value = "Low"; }
                   if(myvalue == 60) { value = "Medium"; }
                   if(myvalue == 100) { value = "High"; }
                }

                $(this).parents(".dashboard-feedback")
                       .children("div.feedback-contents")
                       .children(".responsive-padding")
                       .children(".feedback-details")
                       .children(".feedback-details-status")
                       .children(status_class)
                       .html(value)

                FeedbackService.inline_change($(this).val(), scope.feedid, scope.statustype);
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
                var feedid = $(this).attr('feedid');
                var flag = $(".flag-span[feedid=" + feedid + "]");
                if(!flag.hasClass("feedback-details-flag")) { 
                    flag.addClass("feedback-details-flag");
                    flag.html("FLAGGED");
                } else { 
                    flag.removeClass("feedback-details-flag");
                    flag.html("");
                }
                e.preventDefault();
            })
        }
    }  
});

function published_state(obj, sibling_id, msg, state) { 
    //kill me....
    if(state.activation_color == 'featured') {
        obj.parents('.dashboard-feedback').addClass(state.activation_color);     
        obj.parents('.dashboard-feedback').removeClass('published');     
        obj.children('.action-tooltip').children('span').html("Unfeature");
    } else { 
        obj.parents('.dashboard-feedback').addClass(state.activation_color);     
        obj.parents('.dashboard-feedback').removeClass('featured');     
        obj.children('.action-tooltip').children('span').html("Return to Inbox");
    }
   
    obj.css(state.activate);
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

    var action_delete = obj.parents('.grids').siblings('.grids').children('.action-delete');
    var delete_button = obj.siblings('.save')
                           .children('div.the-categories-menu')
                           .children('.the-categories-menu-content')
                           .children(".the-categories-delete")
                           .children('a');

    var delete_feed_attr = $.parseJSON(action_delete.attr('data-feed'));
    delete_feed_attr.origin = state.present_status;
    var repackaged_feed_attr = JSON.stringify(delete_feed_attr);

    action_delete.attr('data-feed', repackaged_feed_attr);
    delete_button.attr('data-feed', repackaged_feed_attr);
}

function hide_the_children(obj) { 
    obj.parents('.dashboard-feedback').hide();
    var child_count = obj.parents('.feedback-group').children('.dashboard-feedback:visible');
    if(child_count.length == 0) {
        obj.parents('.feedback-group').hide();
    }      
}
