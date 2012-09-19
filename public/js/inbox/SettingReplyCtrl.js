function SettingReplyCtrl($scope) {
 
    $.ajax({
        type: 'GET'    
      , dataType: 'json'
      , async: true
      , url: 'settings/get_msgs'
      , success: function(data) {
            $scope.$apply(function(){
                $scope.msgs = data;      
            }) 
        }
    });

    $scope.get_msgs = function() {
        return $scope.msgs;   
    };

    $scope.add_msg = function($event) {
        if(!$scope.form_msg_text) {
            alert("cannot be blank!");
        } else { 
            $scope.msgs.push({text: $scope.form_msg_text});
            $scope.msgs.form_msg_text = "";

            $.ajax({
                type: 'POST'
              , url: 'settings/save_reply_msg'     
              , data: {"msg": $scope.form_msg_text}
            })

        }
        $event.preventDefault();
    };

    $scope.clear_completed = function($event) {
        var todos = _.filter($scope.todos, function(todo) {
            return !todo.done;     
        })
 
        $scope.todos = todos; 

        $event.preventDefault();
    }
}
