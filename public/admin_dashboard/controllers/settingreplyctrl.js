//Move DOM changing elements to Directive bitch
function SettingReplyCtrl($scope, MessageService) {

    $scope.msgs;
    $scope.type;

    MessageService.get_messages('msg');
    $scope.msgs = MessageService.message;

    $scope.get_msgs = function() {  
        return $scope.msgs;   
    };

    $scope.add_msg = function($event) {

        if(!$scope.form_msg_text) {
            alert("Please provide a reply message.");
        } else { 

            MessageService.save({'text': $scope.form_msg_text, "msgtype": "msg"});
            MessageService.get_messages('msg')
            MessageService.register_reply_message();
            $scope.form_msg_text = null;
        }

        $event.preventDefault();
    };

    $scope.delete_msg = function(id, $event) {
        MessageService.delete_msg(id, 'msg');
        MessageService.get_messages('msg')
        MessageService.register_reply_message();
        $event.preventDefault();
    };

    $scope.update_msg = function(id) {
        console.log("Updating");
        /*
        var me = $($event.target);
        var sib = me.prev();
 
        var input = $("input#" + id + ".dashboard-text");
        var span = $("span#" + id + ".replymsg-text");

        $.ajax({
            type: 'POST'
          , url: '/message/update_reply_msg' 
          , dataType: 'json'
          , data: {"msg": input.val(), "id": id, "type": $scope.type}
          , success: function(data) {
                span.html(data.short_text);
            }
        }); 
        
        me.hide();
        sib.show();
        input.hide();
        span.show();
        $event.preventDefault();
        */
    };

    $scope.$on('fetchReplyMessage', function()  {
        $scope.msgs = MessageService.message;
    });
}
