function SettingReplyCtrl($scope) {

    $scope.todos = [
        {text: 'Mathew is kewl', done: true}
      , {text: 'He loves Irene.', done: true}
    ];

    $scope.msgs;
    
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

    $scope.get_total_msgs = function() {
        return $scope.msgs.length;           
    };

    $scope.get_msgs = function() {
        return $scope.msgs;   
    };

    $scope.add_todo = function($event) {
        if(!$scope.form_todo_text) {
            alert("cannot be blank!");
        } else { 
            $scope.todos.push({text: $scope.form_todo_text, done: false});
            $scope.form_todo_text = null;
        }
        
        $.ajax({
            type: 'POST'
          , url: 'settings/save_reply_msg'     
          , data: {"msg": $scope.todos}
        })

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
