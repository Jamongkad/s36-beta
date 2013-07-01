function ModifyFeedbackControl($scope, FeedbackControlService, FeedbackService, FeedbackSignal) {


    $scope.fast_forward = function(email, feedid) {
        FeedbackService.send_fastforward(email, feedid);
    }

    $scope.save_feedback = function() {

        $scope.feedid = $(".feedid").val();
        $scope.text = $(".feedback-textarea").val();

        console.log($scope.feedid);     
        console.log($scope.text);     
    }
}
