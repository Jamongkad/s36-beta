var app = angular.module("Form", ['CompileHtml']);

app.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: "/api/fullpage_form"
          , controller: "FormCtrl"
        })
        .when('/profile', { 
            templateUrl: "/api/profile"
          , controller: "ProfileCtrl"
        })
        .otherwise({
            redirectTo: "/"     
        })
})

app.controller("FormCtrl", function($scope, $route) {
    $scope.name = "Mathew Jamongkad Wong";
    $scope.firstname = "";
});

app.controller("ProfileCtrl", function($scope, $route) {

    $scope.data = {};

    $.ajax({ 
        type: 'POST'    
      , dataType: 'json'
      , async: false
      , url: '/api/data_pass'
      , data: { 'firstname': $("input[name=firstname]").val(), 'lastname': 'Martie' }
      , success: function(data) {   
            $scope.data = data;
        }
    });

});
