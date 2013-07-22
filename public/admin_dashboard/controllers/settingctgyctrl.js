function SettingCtgyCtrl($scope, Category) {

    $scope.cat = Category.fetch().data;

    $scope.get_category = function() {
        return $scope.cat;
    }

    $scope.add = function() {
        if($scope.category_name == 'undefined' || $scope.category_name == null)  {
            alert("Please provide a category name.");
        } else { 
            console.log($scope.category_name); 
            Category.write($scope.category_name);
            $scope.category_name = null;
        }
    }

    $scope.$on('fetchCategory', function()  {
        $scope.cat = Category.fetch().data;
    });
}
