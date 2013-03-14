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
                scope.time = '<span class="the-date">' + d.toString('MMMM d, yyyy') + '</span>' + ' - <span class="the-time">' + d.toString('h:mm:ss tt') + '</span>';
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
      , scope: {
            load: "=load"   
          , feedid: "=feedid"
        }
      , link: function(scope, element, attrs) { 
            if(scope.load) {
                scope.mtemplate = '<div class="uploaded-images-and-links grids">';               
                for(var prop in scope.load) {
                    var links = scope.load[prop];

                    console.log(links);

                    //videos
                    if(links.hasOwnProperty('video') && links.video == 'yes') { 
                        scope.mtemplate += '<div class="image-block video">';
                        scope.mtemplate += '<a class="fancybox-video" href="' + links.url + '" rel="gallery' + scope.feedid + '">';
                        scope.mtemplate += '<div class="video-circle-ajs"></div>';
                        scope.mtemplate += '<img src="' + links.image + '" width="100%" /></a>';
                        scope.mtemplate += '</div>';
                    }

                    //links
                    if(links.hasOwnProperty('video') && links.video == 'no') { 
                        scope.mtemplate += '<div class="image-block" style="width:100%">';
                        scope.mtemplate += '<div class="the-thumb-ajs"><a href="' + links.url + '" target=newtab>';
                        scope.mtemplate += 'website link: ' + links.title + '<br/>';
                        scope.mtemplate += '<img src="' + links.image + '" width="100%" height="50%"/>';
                        scope.mtemplate += '</a></div>';
                        scope.mtemplate += '</div>';
                    }
                    
                    //pics
                    var box_width;
                    if(links.length == 1) {
                        box_width = "width:100%";
                    }
                    
                    if(links.length == 2) { 
                        box_width = "width:50%";
                    }

                    if(links.length == 3) { 
                        box_width = "width:33%";
                    }
                   
                    for(var i=0; i<links.length; i++) {
                        var file_name = links[i].name;
                        var small_url  = '/uploaded_images/form_upload/small/' + file_name;
                        var medium_url = '/uploaded_images/form_upload/medium/' + file_name;
                        var large_url  = '/uploaded_images/form_upload/large/' + file_name;;

                        scope.mtemplate += '<div class="image-block pic" style="' + box_width + '">';
                            scope.mtemplate += '<a class="the-thumb-ajs" rel="gallery' + scope.feedid + '" href="' +  large_url  + '">';
                                scope.mtemplate += '<img src="' + medium_url + '" width="100%" />';
                            scope.mtemplate += '</a>';
                        scope.mtemplate += '</div>';
                    }                       
                }
                scope.mtemplate += '</div>';
            }
        }
      , template: '<span compile-html="mtemplate"></span>'
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
                var fullpageCommon = new S36FullpageCommon;
                fullpageCommon.init_quick_inbox();
            });
        }
    }    
})
.directive('initquick', function() {
    return {
        restrict: 'A'
      , link: function(scope, element, attrs) { 
            $(element).bind('click', function(e) { 
                var fullpageCommon = new S36FullpageCommon;
                fullpageCommon.init_quick_inbox();
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
