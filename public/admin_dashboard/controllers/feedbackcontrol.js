function FeedbackControl($scope, FeedbackControlService) { 

    $scope.feedback_status = function(id, feed_status) { 
        console.log(feed_status + " id:" + id);
    }

    $scope.reply_feedback = function(id) {
        console.log("reply id:" + id);
    }

}
