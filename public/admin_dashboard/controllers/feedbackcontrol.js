function FeedbackControl($scope, FeedbackControlService) { 

    $scope.feedback_status = function(id, feed_status) { 
        console.log(feed_status + " id:" + id);
    }

    $scope.feature_feedback = function(id) {
        FeedbackControlService.change_status(id);
        console.log("feature id:" + id);
    }
    
    $scope.delete_feedback = function(id) {
        console.log("delete id:" + id);
    }

    $scope.publish_feedback = function(id) {
        console.log("publish id:" + id);
    }

    $scope.reply_feedback = function(id) {
        console.log("reply id:" + id);
    }

    $scope.flag_feedback = function(id) { 
        console.log("flag id:" + id);
    }

}
