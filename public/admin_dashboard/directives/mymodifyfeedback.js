angular.module('modifyfeedback', [])
.directive('forward', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) { 
            $(element).hover(function(e) {
                $(this).siblings('.the-categories-menu').css({'display' : 'block'}).mouseout(function() {
                    $(this).hide();
                })
            });
        }
    }    
})
