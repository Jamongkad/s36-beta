function MainRequestCtrl($scope, MessageService) { 

    $scope.template = { name: "request_form", url: "/feedback/load_request_form" }

    var type = "rqs";
    MessageService.get_messages(type);
    $scope.requests = MessageService.message;

    $scope.get_request_msgs = function() {
        return $scope.requests;     
    }

    $scope.edit_request = function(id, type) {
        MessageService.get_message(id, type);
        $scope.tmplvar = MessageService.msgdata;
        $scope.template = { name: "edit_form", url: "/feedback/load_edit_form/" };
    }

    $scope.add_request = function() { 
        MessageService.msgdata = {};
        MessageService.msgdata.text = null;
        MessageService.msgdata.id = null;
        MessageService.msgdata.msgtype = 'rqs';
        $scope.tmplvar = MessageService.msgdata;
        $scope.template = { name: "edit_form", url: "/feedback/load_edit_form" };
    }

    $scope.del_request = function(id) {
        MessageService.delete_msg(id, 'rqs');
    }
    
    //Broadcast Messages
    $scope.$on('fetchRequestMessage', function()  {
        $scope.$apply(function() {
            $scope.requests = MessageService.message;
        })
    });

}