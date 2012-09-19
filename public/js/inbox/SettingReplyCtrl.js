function SettingReplyCtrl($scope) {
    
    function my_msg() { 
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
    }
    
    my_msg();

    $scope.get_msgs = function() {
        return $scope.msgs;   
    };

    $scope.add_msg = function($event) {

        if(!$scope.form_msg_text) {
            alert("cannot be blank!");
        } else { 
            //$scope.msgs.push({text: $scope.form_msg_text});
            $.ajax({
                type: 'POST'
              , url: 'settings/save_reply_msg'     
              , data: {"msg": $scope.form_msg_text}
              , success: function() {
                    my_msq();
                }
            })
            $scope.form_msg_text = null;
        }

        $event.preventDefault();
    };

    $scope.delete_msg = function(data, $event) {
        console.log(data);
        /*
         *
        $scope.msgs.pop(); 
        var todos = _.filter($scope.todos, function(todo) {
            return !todo.done;     
        })
 
        $scope.todos = todos; 
        */
         
        $event.preventDefault();
    }
}
