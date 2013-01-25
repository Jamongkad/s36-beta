function RequestCtrl($scope, MessageService, FeedbackService) {
    
    var type = "rqs";
    MessageService.get_messages(type);
    $scope.requests = MessageService.message;

    FeedbackService.get_feedback_count();
    $scope.feedback_count = FeedbackService.feedback_count;

    $scope.get_request_msgs = function() {
        return $scope.requests;     
    }

    $scope.get_feedback_count = function() {
        return $scope.feedback_count;     
    }

    $scope.del_request = function(id, $event) {
        MessageService.delete_msg({'id': id, 'type': 'rqs'});
        $event.preventDefault();
    }
    
    //Broadcast Messages
    $scope.$on('addRequestMessage', function()  {
        $scope.$apply(function() {
            $scope.requests = MessageService.message;
        })
    });
}
