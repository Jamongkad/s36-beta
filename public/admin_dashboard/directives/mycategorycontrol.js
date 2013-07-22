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
})
.directive('renameCtgy', function() {
    return {
        restrict: 'A'       
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {
                console.log("Nigguhs");
                e.preventDefault();
            });
        }
    }
    
})
