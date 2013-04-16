function MainReplyCtrl($scope, MessageService) { 
    $scope.template = { name: "test", url: "/feedback/load_reply_form" }

    $scope.get_reply_messages = function() {
        return $scope.messages;    
    }

    $scope.edit_reply = function(id, $event) {
        console.log("edit reply at id " + id);
        $scope.template = { name: "meet", url: "/feedback/load_edit_form" };
    }

    $scope.cancel_reply = function() { 
        $scope.template = { name: "meet", url: "/feedback/load_reply_form" };
    }

    $scope.del_reply = function(id, $event) { 
        MessageService.delete_msg({'id': id, 'type': 'msg'});
    }
     
    //Broadcast Messages
    $scope.$on('fetchReplyMessage', function()  {
        $scope.$apply(function() {
            $scope.messages = MessageService.message;
        })
    });
}
