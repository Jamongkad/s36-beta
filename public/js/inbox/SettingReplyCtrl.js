function SettingReplyCtrl($scope) {
    $scope.total_todos = 9;    

    $scope.todos = [
        {text: 'Mathew is kewl', done: true}
      , {text: 'He loves Irene.', done: true}
    ];

    $scope.add_todo = function($event) {
        $scope.todos.push({text: $scope.form_todo_text, done: false});
        $scope.form_todo_text = '';
        $event.preventDefault();
    };
}
