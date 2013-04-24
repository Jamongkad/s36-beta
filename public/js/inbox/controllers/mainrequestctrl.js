function MainRequestCtrl($scope, MessageService) { 
    $scope.template = { name: "reply_form", url: "/feedback/load_request_form" }

    var type = "rqs";
    MessageService.get_messages(type);
    $scope.requests = MessageService.message;

    $scope.get_request_msgs = function() {
        return $scope.requests;     
    }

    $scope.edit_reply = function(id, type, $event) {
        MessageService.get_message(id, type);
        $scope.tmplvar = MessageService.msgdata;
        $scope.template = { name: "edit_form", url: "/feedback/load_edit_form/" };
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
