angular.module('feedbackcontrol', [])
.directive('feature', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var me = $(element);
                me.parents('.dashboard-feedback').fadeOut(500, function() {
                    var child_count = $(me).parents('.feedback-group').children('.dashboard-feedback:visible');
                    console.log(child_count);
                });
                console.log("Feature Directive");
            });
        }
    } 
});
