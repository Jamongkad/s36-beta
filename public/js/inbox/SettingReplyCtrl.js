function SettingReplyCtrl($scope) {

    $scope.todos = [
        {text: 'Mathew is kewl', done: true}
      , {text: 'He loves Irene.', done: true}
    ];


    $scope.get_total_todos = function() {
        return $scope.todos.length;           
    };

    $scope.add_todo = function($event) {
        if(typeof $scope.form_todo_text === 'undefined') {
            alert("cannot be blank!");
        } else { 
            $scope.todos.push({text: $scope.form_todo_text, done: false});
            $scope.form_todo_text = '';
        }
        $event.preventDefault();
    };
}
