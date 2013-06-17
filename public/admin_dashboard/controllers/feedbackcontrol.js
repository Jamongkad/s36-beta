function FeedbackControl($scope, FeedbackControlService, FeedbackSignal) { 

    $scope.feedbacks = [];
    $scope.selected = [];

    $scope.feedback_status = function(id, feed_status) { 
        console.log(feed_status + " id: " + id);
        FeedbackSignal.prep_status_message(feed_status)
        FeedbackControlService.change_status(id, feed_status);
    }

    $scope.reply_feedback = function(id) {
        console.log("reply id:" + id);
    }

}

function CheckyBox($scope, FeedbackSignal) { 
    $scope.$on('checkFeedbackStatus', function() {
        $scope.status_selection = FeedbackSignal.feed_status;
    });
}
