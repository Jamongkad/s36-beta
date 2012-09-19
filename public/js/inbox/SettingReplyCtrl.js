function SettingReplyCtrl($scope) {

    $scope.todos = [
        {text: 'Mathew is kewl', done: true}
      , {text: 'He loves Irene.', done: true}
    ];


    $scope.get_total_todos = function() {
        return $scope.todos.length;           
    };

    $scope.add_todo = function($event) {
        if(!$scope.form_todo_text) {
            alert("cannot be blank!");
        } else { 
            $scope.todos.push({text: $scope.form_todo_text, done: false});
            $scope.form_todo_text = null;
        }
        
        $.ajax({
            url: 'feedback/save_todos'     
          , type: "POST"
          , data: $scope.todos
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
