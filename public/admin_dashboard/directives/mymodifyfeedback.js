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
                console.log(class_name);

                if(class_name == "blue-bar-feature") { 
                    $(this).css({
                       'background-color': '#e7edf2'
                     , '-webkit-border-radius': '10px'
                     , '-moz-border-radius': '10px'
                     , 'border-radius': '10px'
                    });
                    $(".blue-bar-publish").removeAttr('style');
                }

                if(class_name == "blue-bar-publish") { 
                    $(this).css({
                       'background-color': '#e7edf2'
                     , '-webkit-border-radius': '10px'
                     , '-moz-border-radius': '10px'
                     , 'border-radius': '10px'
                    });
                    $(".blue-bar-feature").removeAttr('style');
                }
                e.preventDefault();
            });
        }
    }     
})
.directive('delete', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).bind('click', function(e) { 
                e.preventDefault();
            });
        }
    }      
})
