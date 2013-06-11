function FeedbackControl($scope) { 

    var feedid = $scope.feedid;
    
    $scope.delete_feedback = function(id) {
        console.log("delete id:" + id);
    }

}
