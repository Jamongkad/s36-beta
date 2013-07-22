function SettingCtgyCtrl($scope, MessageService) {
    $scope.add = function() {
        console.log($scope.category_name); 
        $scope.category_name = null;
    }
}
