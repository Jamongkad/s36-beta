var app = angular.module("Form", ['CompileHtml']);

app.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: "/api/fullpage_form"
          , controller: "FormCtrl"
        })
        .when('/profile', { 
            templateUrl: "/api/profile"
          , controller: "FormCtrl"
        })
        .otherwise({
            redirectTo: "/"     
        })
})

app.controller("FormCtrl", function($scope, $route) {
    console.log($route);
    $scope.name = "Mathew Jamongkad Wong";
});
