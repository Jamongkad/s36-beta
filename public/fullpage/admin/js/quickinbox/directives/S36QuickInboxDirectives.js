angular.module('S36QuickInboxDirectives', [])
.directive('publish', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                console.log(scope.published);
                $(this).parents('.widget-item').fadeOut(300, function() { 
                    $('.widget-list').jScrollPane();
                });
            })
        }
    }    
})
.directive('feature', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                console.log(scope.featured);
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
                console.log(scope.deleted);
                console.log('Ass');
            })
        }
    }     
})
.directive('punch', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                console.log("PUNCH");
            })
        }
    }     
    
})
