var app = angular.module("Form", ['CompileHtml', 'FormServices']);

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

app.controller("FormCtrl", function($scope, $route, Data) {
    $scope.name = Data;
});

app.controller("ProfileCtrl", function($scope, $route, Data) {
    $scope.name = Data;
    /*
    $scope.data = {};
 
    $.ajax({ 
        type: 'POST'    
      , dataType: 'json'
      , async: false
      , url: '/api/data_pass'
      , data: { 'firstname': 'Wong', 'lastname': 'Martie' }
      , success: function(data) {   
            $scope.data = data;
        }
    });
    */

});
