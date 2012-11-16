angular.module('fileupload', [])
.directive('myFileupload', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).fileupload({
                dataType: 'json'     
            });
        }
    }    
})
