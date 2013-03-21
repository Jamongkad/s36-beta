var app = angular.module("Form", ['CompileHtml']);

app.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: "app.html"
          , controller: "FormCtrl"
        })
})

app.controller("FormCtrl", function($scope, $route) {
    $scope.name = "Mathew Jamongkad Wong";
});
