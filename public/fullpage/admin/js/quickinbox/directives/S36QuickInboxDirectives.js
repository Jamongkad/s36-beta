angular.module('S36QuickInboxDirectives', [])
.directive('publish', function($compile) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                console.log(scope.published);
                var me = this;
                $(me).parents('.widget-item').children().fadeOut(400, function() { 
                    $(me).parents('.widget-item').fadeIn().html($compile('<span undo>Undo?</span>')(scope));
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
.directive('undo', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                console.log($(this).parents('.widget-item').children());
            })
        }
    }          
})
