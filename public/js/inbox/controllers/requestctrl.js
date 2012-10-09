function RequestCtrl($scope, MessageService) {
    
    var type = "rqs";
    MessageService.get_messages(type);
    $scope.requests = MessageService.message;
    $scope.type = type;

    $scope.get_request_msgs = function() {
        return $scope.requests;     
    }

    $scope.del_request = function(id, $event) {
        console.log(id);
        $event.preventDefault();
    }
}
