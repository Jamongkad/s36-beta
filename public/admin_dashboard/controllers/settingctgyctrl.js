function SettingCtgyCtrl($scope, Category) {

    Category.fetch();
    $scope.cat = Category.cat_data.data;

    $scope.get_category = function() {
        return $scope.cat;
    }

    $scope.add = function() {
        if($scope.category_name == 'undefined' || $scope.category_name == null)  {
            alert("Please provide a category name.");
        } else { 
            Category.write($scope.category_name);
            $scope.category_name = null;
        }
    }

    $scope.$on('fetchCategory', function()  {
        console.log("Fetching Category");
        Category.fetch();
        $scope.cat = Category.cat_data.data; 
        console.log($scope.cat);
    });
}
