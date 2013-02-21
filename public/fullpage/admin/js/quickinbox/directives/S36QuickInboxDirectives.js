angular.module('S36QuickInboxDirectives', [])
/*
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
*/
.directive('publish', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                /*
                var me = this;
                feedback_fadein(me);
                */
                console.log($('.widget-list input[type=checkbox][name=feedid]:checked'));
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
.directive('infoblock', function() { 
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) {
            attrs.$observe('load', function(at) {
                var data = angular.fromJson(at);
                if(data.attachments || data.metadata) {
                    $(element).addClass("additional-info");
                }
            }) 
        }
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
                    scope.template = '<div class="custom-meta-list grids">';     
                    for(var prop in data) {
                        var meta = data[prop];
                        scope.template += '<div class="custom-meta">';
                        for(var pr in meta)  {
                            scope.template += '<div class="custom-meta-name">';
                            var submeta = meta[pr]; 
                            //console.log(ucwords(pr.replace(/_/g, " ")));
                            scope.template += ucwords(pr.replace(/_/g, " ")) + ": ";
                            var prefix = "";
                            for(var i=0; i<submeta.length; i++) {
                                //console.log(" -" + submeta[i].value);   
                                scope.template += '<span class="value">' + prefix + submeta[i].value + '</span>';
                                prefix = ", ";
                            } 
                            scope.template += '</div>';
                        }
                        scope.template += '</div>';
                    }
                    scope.template += '</div>';     
                }
            });
        } 
      , template: '<span compile-html="template"></span>'
    } 
})
.directive('attachments', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            attrs.$observe('load', function(at) {
                if(at) {
                    var data = angular.fromJson(at);
                    //console.log(data);
                    scope.mtemplate = '<div class="uploaded-images-and-links grids">';
                    for(var prop in data) {
                        var links = data[prop];

                        //videos
                        if(links.hasOwnProperty('video') && links.video == 'yes') { 
                            scope.mtemplate += '<div class="image-block video">';
                            scope.mtemplate += '<div class="video-circle-ajs" link-url="' + links.url + '" open-video></div>';
                            scope.mtemplate += '<div class="the-thumb-ajs" ><img src="' + links.image + '" width="100%" /></div>';
                            scope.mtemplate += '</div>';
                        }

                        //links
                        if(links.hasOwnProperty('video') && links.video == 'no') { 
                            scope.mtemplate += '<div class="image-block">';
                            scope.mtemplate += '<div class="the-thumb-ajs" ng-click="test_punch(1000)"><a href="' + links.url + '">linky</a></div>';
                            scope.mtemplate += '</div>';
                        }
                        
                        //pics
                        for(var i=0; i<links.length; i++) {
                            /* 
                            scope.mtemplate += '<div class="delete-block"  punch mid="' + meta[i].mid + '">x</div>';
                            */
                            scope.mtemplate += '<div class="image-block pic">';
                            scope.mtemplate += '<div class="the-thumb-ajs" open-pic load="' +  links[i].large_url  + '">';
                            scope.mtemplate += '<img src="' + links[i].small_url + '" width="100%" /></div>';
                            scope.mtemplate += '</div>';
                        }                       

                    }
                    scope.mtemplate += '</div>';
                }
            });
        }
      , template: '<span compile-html="mtemplate"></span>'
    }    
})
.directive('openVideo', function() {
    return {  
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function() { 

                var scroll_offset = $(document).scrollTop();
                var top_offset = scroll_offset + 100;
                var embed_url = $(this).attr('link-url').replace('www.youtube.com/watch?v=','www.youtube.com/embed/');
                var html  = '<iframe width="770" height="400" src="'+embed_url+'" frameborder="0" allowfullscreen></iframe>';

                $('.lightbox').fadeIn().css('top', top_offset);
                $('.uploaded-images-content').html(html);
            })
        }
    }    
})
.directive('openPic', function() { 
    return {  
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            attrs.$observe('load', function(at) {
                $(element).bind('click', function() { 
                    var scroll_offset = $(document).scrollTop();
                    var top_offset = scroll_offset + 100;
                    $('.lightbox').fadeIn().css('top', top_offset);
                    var html = '<img src="' + at + '" width="100%" />';
                    $('.uploaded-images-content').html(html);
                })
            })
        }
    }    
})
.directive('checkfeed', function() { 
    return {  
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function() {
                $("#quickInboxActions").show();
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
