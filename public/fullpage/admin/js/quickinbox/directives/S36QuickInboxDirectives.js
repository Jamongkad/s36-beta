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
                var me = this;
                feedback_fadein(me);
            })
        }
    }     
})
.directive('delete', function() {
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
.directive('undo', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                var me = this;
                feedback_fadeout(me);
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
.directive('social', function() {
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
            attrs.$observe('login', function(nv) {
                if(nv == 'fb') {
                    scope.socialsrc = "<img src='img/small-fb-icon.png'/> Facebook Verified";     
                } 
            }) 
        }
      , template: '<spa ng-bind-html-unsafe="socialsrc"></span>'
    } 
})
.directive('feedbackDate', function() { 
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
            attrs.$observe('date', function(nv) {
                console.log(nv);
            }) 
        }
      //, template: '<spa ng-bind-html-unsafe="socialsrc"></span>'
    } 
})

//helper functions
function feedback_fadein(elem) { 
    $(elem).parents('.widget-item').children('.widget-avatar, .widget-content, .widget-actions').fadeOut(400, function() { 
        $(elem).parents('.widget-item').children('.widget-undo').show();
        $('.widget-list').jScrollPane();
    });
}

function feedback_fadeout(elem) {
    $(elem).parents('.widget-item').children('.widget-undo').hide();
    $(elem).parents('.widget-item').children('.widget-avatar, .widget-content, .widget-actions').fadeIn(400, function() { 
        $('.widget-list').jScrollPane();
    });
}
