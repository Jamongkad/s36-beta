angular.module('AdminDirectives', [])
.directive('publish', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                console.log(scope.published);
                console.log('Boobies');
            })
        }
    }    
})
.directive('feature', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                console.log('Tits');
            })
        }
    }     
})
.directive('delete', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                console.log('Ass');
            })
        }
    }     
})
