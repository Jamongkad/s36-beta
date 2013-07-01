angular.module('modifyfeedback', [])
.directive('forward', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).hover(function(e) {
                console.log("Hover in");
            }, function(e) {
                console.log("Hover out");
            });
        }
    }    
})
