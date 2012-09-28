angular.module('request', [])
.directive('myRequest', function() {
    return function(scope, element, attr) {
        $(element).bind('click', function(e) {
            e.preventDefault();
        })
    }
})
