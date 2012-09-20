function SettingReplyCtrl($scope, MessageService) {

    $scope.msgs = MessageService.message;

    $scope.get_msgs = function() {
        return $scope.msgs;   
    };

    $scope.add_msg = function($event) {

        if(!$scope.form_msg_text) {
            alert("cannot be blank!");
        } else { 
            $.ajax({
                type: 'POST'
              , url: 'message/save__msg'     
              , dataType: 'json'
              , data: {"msg": $scope.form_msg_text, "type": "msg"}
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

    $scope.delete_msg = function(data, $event) {
        $.ajax({
            url: 'message/delete_msg/' + data
          , success: function() { $("div#" + data + ".grids").remove(); }
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
          , data: {"msg": input.val(), "id": id}
        }); 

        span.text(input.val());
        
        me.hide();
        sib.show();
        input.hide();
        span.show();
        $event.preventDefault();
    };
}
