function FeedbackCountCtrl($scope, FeedbackService) {

    FeedbackService.get_feedback_count();
    $scope.counts = FeedbackService.feedback_count;

    $scope.get_feedback_count = function() {
        console.log($scope.counts);
        return $scope.counts;     
    }

    //Broadcast Messages
    /*
    $scope.$on('requestFeedbackCount', function()  {
        $scope.$apply(function() {
            $scope.counts = FeedbackService.feedback_count;
        })
    });
    */
}
