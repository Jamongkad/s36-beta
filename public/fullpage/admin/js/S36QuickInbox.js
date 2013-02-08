var app = angular.module("QuickInbox", []);

app.controller("AppCtrl", function($scope) {
    this.say_hi = function() {
        Alert("Mathew");
    }

    return $scope.AppCtrl = this;
});
