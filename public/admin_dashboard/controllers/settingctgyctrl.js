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
            if($scope.cat.length == 6) {
                $("#add-ctgy").hide();
            }
        }
    }

    $scope.$on('fetchCategory', function()  {
        Category.fetch();
        $scope.cat = Category.cat_data.data; 
    });
}
