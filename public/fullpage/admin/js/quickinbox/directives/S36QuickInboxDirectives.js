angular.module('S36QuickInboxDirectives', [])
.directive('publish', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                var me = this;
                feedback_fadein(me);
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
                var me = this;
                feedback_fadein(me);
            })
        }
    }          
})

//helper functions
function feedback_fadein(elem) { 
    $(elem).parents('.widget-item').children('.widget-avatar, .widget-content, .widget-actions').fadeOut(400, function() { 
        $(elem).parents('.widget-item').children('.widget-undo').show();
        $('.widget-list').jScrollPane();
    });
}

function feedback_fadein(elem) {
    $(elem).parents('.widget-item').children('.widget-avatar, .widget-content, .widget-actions').fadeIn(400, function() { 
        $(elem).parents('.widget-item').children('.widget-undo').hide();
        $('.widget-list').jScrollPane();
    }); 
}
