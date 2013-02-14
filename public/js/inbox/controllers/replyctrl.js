function ReplyCtrl($scope, MessageService) { 

    $scope.messages;

    $scope.get_reply_messages = function() {
        return $scope.messages;    
    }

    $scope.del_reply = function(id) { 
        MessageService.delete_msg({'id': id, 'type': 'msg'});
    }
     
    //Broadcast Messages
    $scope.$on('fetchReplyMessage', function()  {
        $scope.$apply(function() {
            $scope.messages = MessageService.message;
        })
    });
}
