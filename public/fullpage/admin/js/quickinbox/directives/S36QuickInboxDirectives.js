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
            attrs.$observe('login', function(at) {
                if(at == 'fb') {
                    scope.socialsrc = "<img src='img/small-fb-icon.png'/> Facebook Verified";     
                } 
            }) 
        }
      , template: '<spa ng-bind-html-unsafe="socialsrc"></span>'
    } 
})
.directive('feedbackdate', function() { 
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
            attrs.$observe('date', function(at) {
                var d = Date.parse(at);
                scope.time = '<div class="the-date">' + d.toString('MMMM d, yyyy') + '</div>' + '<div class="the-time">' + d.toString('h:mm:ss tt') + '</div>';
            }) 
        }
      , template: '<spa ng-bind-html-unsafe="time"></span>'
    } 
})
.directive('metadata', function() { 
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
            attrs.$observe('load', function(at) {
                if(at) {
                    var data = angular.fromJson(at);
                    //console.log(data);
                    for(var prop in data) {
                        var meta = data[prop];
                        for(var pr in meta)  {
                            var submeta = meta[pr];
                            //console.log(pr);
                            console.log(ucwords(pr.replace(/_/g, " ")));
                            for(var i=0; i < submeta.length; i++) {
                                console.log(submeta[i]);   
                                console.log(submeta[i].value);   
                            }
                        }
                        /*
                        for(var i=0; i < meta.length; i++) {
                            console.log(meta);   
                        }
                        */
                    }
                    /*
                    var template = '<div class="custom-meta-list grids">'
                    for(var i=0; i < meta.length; i++) {
                        template += '<div class="custom-meta">'           
                        template += '<div class="custom-meta-name">' + meta[i].key + ' : <span class="value">' + meta[i].value + '</span></div>'
                        template += '</div>'
                    }
                    template += '</div>';
                    */
                }
            }) 
        }
    } 
});

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

function ucwords(str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}
