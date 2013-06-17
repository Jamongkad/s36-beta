function FeedbackControl($scope, FeedbackControlService) { 

    $scope.status_selection;

    $scope.feedback_status = function(id, feed_status) { 
        console.log(feed_status + " id: " + id);
        $scope.status_selection = feed_status;
        FeedbackControlService.change_status(id, feed_status);
    }

    $scope.reply_feedback = function(id) {
        console.log("reply id:" + id);
    }

}
