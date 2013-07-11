//Move DOM changing elements to Directive bitch
function SettingReplyCtrl($scope, MessageService) {

    $scope.msgs;
    $scope.type;

    MessageService.get_messages('msg');
    MessageService.register_reply_message();

    $scope.get_msgs = function() {
        return $scope.msgs;   
    };

    $scope.add_msg = function($event) {
        /* 
        if(!$scope.form_msg_text) {
            alert("Please provide a reply message.");
        } else { 
            $.ajax({
                type: 'POST'
              , url: '/message/save_msg'     
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
        */
        console.log($scope.form_msg_text);
        console.log('msg');
        $event.preventDefault();
    };

    $scope.delete_msg = function(id, $event) {
        $.ajax({
            url: '/message/delete_msg'
          , type: 'POST' 
          , data: {"id": id, "type": $scope.type}
          , success: function() { $("div#" + id + ".grids").remove(); }
        }); 
        $event.preventDefault();
    };

    $scope.edit_msg = function(id, $event) {        

        var me = $($event.target);
        var sib = me.next();

        console.log(id);

        var input = $("input#" + id + ".dashboard-text");
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
    };

    $scope.$on('fetchReplyMessage', function()  {
        $scope.$apply(function() {
            $scope.messages = MessageService.message;
        })
    });

}
