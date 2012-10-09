angular.module('Components', ['reply', 'request'])
.directive('helloSettings', function() {
    return {
        restrict: 'E'     
      , template: '<h3>EMAIL SETTINGS</h3>'
    }  
})
