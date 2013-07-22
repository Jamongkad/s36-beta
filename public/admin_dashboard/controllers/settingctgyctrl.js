function SettingCtgyCtrl($scope, Category) {

    var cat = Category.fetch();

    $scope.get_category = function() {
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
