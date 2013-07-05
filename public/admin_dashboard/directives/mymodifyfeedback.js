angular.module('modifyfeedback', [])
.directive('forward', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).hover(function(e) {
                $(this).siblings('.the-modify-categories-menu').css({'display' : 'block'}).hover(function() {}, function() {
                    $(this).hide();
                })
            });
        }
    }    
})
.directive('saveFeedback', function() { 
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).bind('click', function(e) {
                e.preventDefault();
            });
        }
    }    
})
.directive('toggle', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).bind('click', function(e) {
                var class_name = $(this).attr('class');

                if(class_name == "blue-bar-feature") { 
                    $(this).css({
                       'background-color': '#e7edf2'
                     , '-webkit-border-radius': '10px'
                     , '-moz-border-radius': '10px'
                     , 'border-radius': '10px'
                    });
                    $(".blue-bar-publish").removeAttr('style');
                    $(".cat-picks").removeAttr('style');
                }

                if(class_name == "blue-bar-publish") { 
                    $(this).css({
                       'background-color': '#e7edf2'
                     , '-webkit-border-radius': '10px'
                     , '-moz-border-radius': '10px'
                     , 'border-radius': '10px'
                    });
                    $(".blue-bar-feature").removeAttr('style');
                    $(".cat-picks").removeAttr('style');
                }

                if(class_name == "blue-bar-flag") { 
                    var state = $(this).attr('state');
                    if(state == 1) {
                        $(this).removeAttr('style');
                        $(this).attr('state', 0);
                    } else { 
                        $(this).css({
                           'background-color': '#e7edf2'
                         , '-webkit-border-radius': '10px'
                         , '-moz-border-radius': '10px'
                         , 'border-radius': '10px'
                        });
                        $(this).attr('state', 1);
                    }
                }

                if(class_name == "blue-bar-delete") { 
                    $(".blue-bar-feature, .blue-bar-publish, .blue-bar-flag, .cat-picks").removeAttr('style');
                    var str = construct_query_string();

                    alert("This feedback has been deleted.");

                    var inbox_location, page = '';
                    if(str.b == "inbox") { 
                        inbox_location = "/inbox/all";
                    }

                    if(str.b == "publish") { 
                        inbox_location = "/inbox/published/all";
                    }

                    if(str.b == "fileas") { 
                        inbox_location = "/inbox/filed/all";
                    }

                    if(str.b == "delete") {
                        inbox_location = "/inbox/deleted/all";
                    }

                    if('p' in str) {
                        page = "?page=" + str.p;
                    }
                    window.location = inbox_location + page; 
                }
                e.preventDefault();
            });
        }
    }     
})
.directive('categoryPick', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind("click", function(e) { 

                var deselect_this = false;

                $(this).parent().siblings().children('a').each(function() {
                    $(this).removeAttr("style");     
                });

                if(!deselect_this) {
                    $(this).attr('style', "background: #cd5555");
                }

                $(".blue-bar-feature").removeAttr('style');
                $(".blue-bar-publish").removeAttr('style');
                e.preventDefault();
            });
        }
    }    
})

function construct_query_string() {
    var prmstr = window.location.search.substr(1);
    var prmarr = prmstr.split ("&");
    var params = {};

    for(var i = 0;i<prmarr.length;i++) {
        var tmparr = prmarr[i].split("=");
        params[tmparr[0]] = tmparr[1];
    }

    return params;
}
