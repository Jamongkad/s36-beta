function ModifyFeedbackControl($scope, FeedbackControlService, FeedbackService, FeedbackSignal) {


    $scope.fast_forward = function(email, feedid) {
        FeedbackService.send_fastforward(email, feedid);
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
}
