function FeedbackCountCtrl($scope, FeedbackService) {

    var self = this;

    FeedbackService.get_feedback_count();
    var feedback_counts = FeedbackService.feedback_count;
    $scope.counts = feedback_counts; 

    $scope.get_feedback_count = function() {
        return $scope.counts;     
    }

    $scope.get_class = function() {
        if(self.counts.checked == 0) {
            return "count";
        }

        return "";
    }

    $scope.display_count = function() {
        if(feedback_counts.counts.checked == 0)
            return feedback_counts.counts.feedback_count;
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
