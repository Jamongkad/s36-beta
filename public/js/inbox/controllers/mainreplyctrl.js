function MainReplyCtrl($scope, MessageService) { 

    $scope.template = { name: "reply_form", url: "/feedback/load_reply_form" }

    $scope.get_reply_messages = function() {
        return $scope.messages;    
    }

    $scope.edit_reply = function(id, type, $event) {
        MessageService.get_message(id, type);
        $scope.tmplvar = MessageService.msgdata;
        $scope.template = { name: "edit_form", url: "/feedback/load_edit_form/" };
    }

    $scope.add_reply = function() { 
        MessageService.msgdata = {};
        MessageService.msgdata.text = null;
        MessageService.msgdata.id = null;
        MessageService.msgdata.msgtype = 'msg';
        $scope.tmplvar = MessageService.msgdata;
        $scope.template = { name: "edit_form", url: "/feedback/load_edit_form" };
    }
    

    $scope.cancel_reply = function() { 
        $scope.template = { name: "reply_form", url: "/feedback/load_reply_form" };
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

    $scope.$on('fetchReplyBody', function() {
        $scope.$apply(function() {
            $scope.replybody = MessageService.replybody;
        }) 
    })
}
