function FeedbackControl($scope) { 

    var feedid = $scope.feedid;
    console.log($scope.catid);
    
    $scope.delete_feedback = function() {
        console.log("delete id:" + this.feedid);
    }

}
