function ParentCtrl($scope) {

    $scope.msgs;
    $scope.type;

    $scope.get_msgs = function() {
        return $scope.msgs;   
    };

    $scope.add_msg = function($event) {

        if(!$scope.form_msg_text) {
            alert("cannot be blank!");
        } else { 
            $.ajax({
                type: 'POST'
              , url: 'message/save_msg'     
              , dataType: 'json'
              , data: {"msg": $scope.form_msg_text, "type": $scope.type}
              , success: function(data) {
                    $scope.$apply(function(){
                        $scope.msgs.push(data);
                    }) 
                }
            })
            $scope.form_msg_text = null;
        }
        $event.preventDefault();
    };

    $scope.delete_msg = function(id, $event) {
        $.ajax({
            url: 'message/delete_msg'
          , type: 'POST' 
          , data: {"id": id, "type": $scope.type}
          , success: function() { $("div#" + id + ".grids").remove(); }
        }); 
        $event.preventDefault();
    };

    $scope.edit_msg = function(id, $event) {        

        var me = $($event.target);
        var sib = me.next();

        var input = $("input#" + id + "[name=reply_message]");
        var span = $("span#" + id + ".replymsg-text");
     
        me.hide();
        sib.show();
        input.show();
        span.hide();
        $event.preventDefault();
    };

    $scope.update_msg = function(id, $event) {

        var me = $($event.target);
        var sib = me.prev();
 
        var input = $("input#" + id + "[name=reply_message]");
        var span = $("span#" + id + ".replymsg-text");

        $.ajax({
            type: 'POST'
          , url: 'message/update_reply_msg' 
          , dataType: 'json'
          , data: {"msg": input.val(), "id": id, "type": $scope.type}
        }); 
        
        me.hide();
        sib.show();
        input.hide();
        span.show();
        $event.preventDefault();
    };
}

function SettingReplyCtrl($scope, $injector, MessageService) { 
    $injector.invoke(ParentCtrl, this, {$scope: $scope});

    var type = "msg";
    MessageService.get_messages(type);
    $scope.msgs = MessageService.message;
    $scope.type = type;
}

function SettingRequestCtrl($scope, $injector, MessageService) { 
    $injector.invoke(ParentCtrl, this, {$scope: $scope});
    
    var type = "rqs";
    MessageService.get_messages(type);
    $scope.msgs = MessageService.message;
    $scope.type = type;
}

SettingReplyCtrl.prototype = Object.create(ParentCtrl.prototype);
SettingRequestCtrl.prototype = Object.create(ParentCtrl.prototype);
