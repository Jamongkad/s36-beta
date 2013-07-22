function SettingCtgyCtrl($scope, Category) {

    $scope.get_category = function() {
        var cat = Category.fetch();
        console.log(cat);     
        return cat;
    }

    $scope.add = function() {
        if($scope.category_name == 'undefined' || $scope.category_name == null)  {
            alert("Please provide a category name.");
        } else { 
            console.log($scope.category_name); 
            $scope.category_name = null;
        }
    }
}
