function SettingCtgyCtrl($scope, MessageService) {
    $scope.add = function() {
        console.log("You are my fire");
    }
}

angular.module('categorycontrol', [])
.directive('add', function() {    
    return {
        restrict: 'A'       
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                e.preventDefault();
            });
        }
    }
});
