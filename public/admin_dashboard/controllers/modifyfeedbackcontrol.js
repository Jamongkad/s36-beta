function ModifyFeedbackControl($scope, FeedbackControlService, FeedbackService, FeedbackSignal) {

    var current_url = window.location.pathname;
    var current_cat_id = $(".category-box").attr('id');

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
    }

    $scope.save_feedback = function() {

        var feedid = $(".feedid").val();
        var text = $(".feedback-textarea").val();

        $.ajax({
            url: '/feedback/edit_feedback_text'              
          , type: 'POST'
          , dataType: 'json'
          , data: { feed_id: feedid, feedback_text: text } 
          , success: function(msg) { 

                if(msg.save == 1) {
                    alert("Feedback text successfully edited!");     
                }
               
            }
        });
    }

    $scope.feedback_status = function($event) {
        var target = $($event.target);
        var feed = $.parseJSON(target.attr('data-feed')); 
        FeedbackControlService.change_status(feed, true);
    }

    $scope.toggle_lock = function($event) {
        var target = $($event.target);
        target.is(':checked');
        console.log();
        console.log("Toggle lock");
    }

    $scope.toggle_display = function() { 
        console.log("Toggle display");
    }
}
