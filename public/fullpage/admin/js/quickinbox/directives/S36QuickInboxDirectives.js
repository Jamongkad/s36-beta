angular.module('S36QuickInboxDirectives', [])
.directive('feedbackout', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {  
                $('.widget-list input[type=checkbox][name=feedid]:checked').parents('div.widget-item').fadeOut();
            });
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
      , template: '<span ng-bind-html-unsafe="socialsrc"></span>'
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
      , template: '<span ng-bind-html-unsafe="time"></span>'
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
            console.log(attrs);
            /*
            attrs.$observe('load', function(at) {
                if(at) {
                    var data = angular.fromJson(at);
                    console.log(data);
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
                            scope.mtemplate += '<div class="the-thumb-ajs"><a href="' + links.url + '">linky</a></div>';
                            scope.mtemplate += '</div>';
                        }
                        
                        //pics
                        for(var i=0; i<links.length; i++) {

                            var file_name = links[i].name;
                            var small_url  = '/uploaded_images/form_upload/small/' + file_name;
                            var medium_url = '/uploaded_images/form_upload/medium/' + file_name;
                            var large_url  = '/uploaded_images/form_upload/large/' + file_name;;

                            scope.mtemplate += '<div class="image-block pic">';
                            scope.mtemplate += '<div class="the-thumb-ajs" open-pic  ng-click="test_punch(1000)" load="' +  large_url  + '">';
                            scope.mtemplate += '<img src="' + small_url + '" width="100%" /></div>';
                            scope.mtemplate += '</div>';
                        }                       

                    }
                    scope.mtemplate += '</div>';
                }
            });
            */
        }
      , template: '<span compile-html="mtemplate"></span>'
    }    
})
.directive('openVideo', function() {
    return {  
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function() { 
                console.log("Video Open");
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
})
.directive('scrollpane', function() {
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) { 
            scope.$watch(function() {
                $('.widget-list').jScrollPane();
                return element.find('.widget-item').length;
            }, function(length) {

                var pane = $('.widget-list').jScrollPane();
                var api = pane.data('jsp');

                if(api) {
                    api.destroy();
                }

                setTimeout(function() {
                    $('.widget-list').jScrollPane();
                }, 0);
            });
        }
    }    
})
.directive('initquick', function() {
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) { 
            $(element).bind('click', function(e) {

                   var pane = $('.widget-list').jScrollPane();
                   var api = pane.data('jsp');
                   api.destroy();
                   console.log(api);
                   setTimeout(function() {
                       $('.widget-list').jScrollPane();
                   }, 200);

                e.preventDefault();
            });
        }
    }        
});

//helper functions
function ucwords(str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}
