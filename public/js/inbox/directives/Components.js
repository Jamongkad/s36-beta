angular.module('Components', [])
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<span>Mathew & Irene are awesome!</span>'
    }  
});
