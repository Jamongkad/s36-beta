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
            var result = Category.write_result;
            $scope.category_name = null;
            if(result.status == "max") {
                alert("Max categories reached!");    
            }             
        }
    }

    $scope.$on('fetchCategory', function()  {
        Category.fetch();
        $scope.cat = Category.cat_data.data; 
    });
}
