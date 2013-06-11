function FeedbackControl($scope) { 

    var feedid = $scope.feedid;
    console.log($scope.catid);
    
    $scope.delete_feedback = function(id) {
        console.log("delete id:" + id);
    }

}
