function ModifyFeedbackControl($scope, FeedbackControlService, FeedbackService, FeedbackSignal) {
    $scope.fast_forward = function(email, feedid) {
        FeedbackService.send_fastforward(email, feedid);
    }

    $scope.save_feedback = function() {
        console.log($scope.feedid);     
        console.log($scope.feedback_text);     
    }
}
