//this directive binds dynamically generate html to angular global scope
angular.module('CompileHtml', [])
.directive('compileHtml', function($compile) {
    return {
        restrict: 'A'     
      , scope: { compileHtml: '=' }
      , replace: true
      , link: function(scope, element, attrs) {
            scope.$watch('compileHtml', function(value) {
                element.html ( $compile(value)(scope.$parent) );
            })
        }
    }     
})
