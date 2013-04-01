var app = angular.module("Form", ['CompileHtml', 'FormServices', 'FormDirectives']);

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
        .when('/review', { 
            templateUrl: "/api/review"
          , controller: "ReviewCtrl"
        })
        .when('/submission_send', { 
            templateUrl: "/api/submission_send"
          , controller: "SubmissionCtrl"
        })
        .otherwise({
            redirectTo: "/"     
        })
})

app.controller("FormCtrl", function($scope, $route, Data) {
    $scope.data = Data;
});

app.controller("ProfileCtrl", function($scope, $route, Data) {
    $scope.data = Data;
});

app.controller("ReviewCtrl", function($scope, $route, Data) {
    $scope.data = Data;
});

app.controller("SubmissionCtrl", function($scope, $route, Data) {
    $.ajax({     
        type: 'POST'    
      , dataType: 'json'
      , data: {'formdata': Data}
      , async: false
      , url: '/api/send_now'
    })
    
    //Clear all fields
    Data.rating = null;
    Data.title = null;
    Data.feedbacktext = null;
    Data.firstname = null;
    Data.lastname = null;
});
