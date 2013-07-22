function SettingCtgyCtrl($scope, Category) {

    Category.fetch();

    $scope.add = function() {
        if($scope.category_name == 'undefined' || $scope.category_name == null)  {
            alert("Please provide a category name.");
        } else { 
            console.log($scope.category_name); 
            $scope.category_name = null;
        }
    }
}
