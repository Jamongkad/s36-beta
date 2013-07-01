function ModifyFeedbackControl($scope, FeedbackControlService, FeedbackService, FeedbackSignal) {
    $scope.fast_forward = function(email, feedid) {
        FeedbackService.send_fastforward(email, feedid);
    }
}
