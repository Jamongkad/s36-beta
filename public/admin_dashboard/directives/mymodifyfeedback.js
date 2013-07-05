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
                    alert("This feedback has been deleted.");
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
