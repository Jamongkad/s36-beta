function FeedbackCountCtrl($scope, FeedbackService) {

    FeedbackService.get_feedback_count();
    $scope.counts = FeedbackService.feedback_count;

    $scope.get_feedback_count = function() {
        return $scope.counts;     
    }

    $scope.get_class = function(index) {
        if(index == "1") {
            return "count";
        }

        return "";
    }

    $scope.display_count = function() {
        if($scope.checked == 0)
            return $scope.feedback_count;
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
