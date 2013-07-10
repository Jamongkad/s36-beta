function ModifyFeedbackControl($scope, FeedbackControlService, FeedbackService, FeedbackSignal, ModifyFeedback) {

    var current_url = window.location.pathname;
    var current_cat_id = $(".category-box").attr('id');
    var feedid = $(".feedid").val();

    $scope.fast_forward = function(email, feedid) {
        FeedbackService.send_fastforward(email, feedid);
    }

    $scope.change_status = function(feedid, status_change) {

        var status_change = {
            id: feedid     
          , status: status_change
          , catid: current_cat_id
        }

        FeedbackControlService.change_status(status_change, true);

        if(FeedbackControlService.jsonmsg.feedback_status_change == "success") { 

            var str = construct_query_string();
            var inbox_location, page = '';
            if(str.b == "inbox") { 
                inbox_location = "/inbox/all";
            }

            if(str.b == "publish") { 
                inbox_location = "/inbox/published/all";
            }

            if(str.b == "fileas") { 
                inbox_location = "/inbox/filed/all";
            }

            if(str.b == "delete") {
                inbox_location = "/inbox/deleted/all";
            }

            if('p' in str) {
                page = "?page=" + str.p;
            }

            window.location = inbox_location + page; 
        }
    }

    $scope.save_feedback = function() { 
        var text = $(".feedback-textarea").val();
        var data = { feed_id: feedid, feedback_text: text };
        ModifyFeedback.edit_feedback_text(data);
    }

    $scope.feedback_status = function($event) {
        var target = $($event.target);
        var feed = $.parseJSON(target.attr('data-feed')); 
        FeedbackControlService.change_status(feed, true);
    }

    $scope.toggle_feedback_display_lock = function($event) {
        var target = $($event.target);
        var checked = target.is(':checked'); 
        var data = { feedid: feedid, status: checked };

        ModifyFeedback.lock_feedback_display(data);
    }

    $scope.toggle_display = function($event) { 
        var target = $($event.target); 
        var checked = target.is(':checked');
        var column = target.attr('name');
        var data = {feedid: feedid, status: checked, column: column};

        ModifyFeedback.display_toggle(data);
    }
}

function construct_query_string() {
    var prmstr = window.location.search.substr(1);
    var prmarr = prmstr.split ("&");
    var params = {};

    for(var i = 0;i<prmarr.length;i++) {
        var tmparr = prmarr[i].split("=");
        params[tmparr[0]] = tmparr[1];
    }

    return params;
}
