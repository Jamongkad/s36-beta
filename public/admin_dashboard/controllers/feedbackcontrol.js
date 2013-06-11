function FeedbackControl($scope) { 
    console.log($scope.feedid);
    console.log($scope.catid);
    
    $scope.delete_feedback = function() {
        console.log("delete id:" + $scope.feedid);
    }

}
