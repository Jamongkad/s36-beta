angular.module('feedbackcontrol', [])
.directive('feature', function(FeedbackControlService, $compile) {
    return {
        restrict: 'A'     
      , link: function($scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var me = $(element);
                me.parents('.dashboard-feedback').fadeOut(500, function() {
                    var child_count = $(me).parents('.feedback-group').children('.dashboard-feedback:visible');
                    if(child_count.length == 0) {
                        $(me).parents('.feedback-group').fadeOut(500);
                    }

                    var html_str = $compile("<span undo></span>")($scope);

                    $(".checky-bar").html("Undo this shit mah nigguh? " + html_str);
                });
                console.log("Feature Directive");
            });
        }
    } 
})
.directive('undo', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            scope.template = "Mathew";
        }
      , template: '<span compile-html="template"></span>'
    }    
})
