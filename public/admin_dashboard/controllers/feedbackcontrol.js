function FeedbackControl($scope, FeedbackControlService) { 

    $scope.feature_feedback = function(id) {
        FeedbackControlService.feedid = id;
        $scope.feedid = id;
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
