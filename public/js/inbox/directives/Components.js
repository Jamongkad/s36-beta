angular.module('Components', [])
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<span>Mathew is awesome!</span>'
    }  
});
