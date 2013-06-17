function FeedbackControl($scope, FeedbackControlService, FeedbackSignal) { 

    $scope.feedback_status = function(id, feed_status) { 
        console.log(feed_status + " id: " + id);
        FeedbackSignal.feed_status = feed_status;
        FeedbackControlService.change_status(id, feed_status);
    }

    $scope.reply_feedback = function(id) {
        console.log("reply id:" + id);
    }

}

function CheckyBox($scope, FeedbackSignal) {
    $scope.status_selection = FeedbackSignal.feed_status;
}
