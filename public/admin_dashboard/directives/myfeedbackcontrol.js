angular.module('feedbackcontrol', [])
.directive('feature', function(FeedbackControlService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var me = $(element);
                me.parents('.dashboard-feedback').fadeOut(500, function() {
                    var child_count = $(me).parents('.feedback-group').children('.dashboard-feedback:visible');
                    if(child_count.length == 0) {
                        $(me).parents('.feedback-group').fadeOut(500);
                    }

                    $(".checky-bar").html("Undo this shit mah nigguh? <a class='undo' href='#'>Undo</a> <a class='close-checky' href='#'>Close</a>");
                });
                console.log("Feature Directive");
            });
        }
    } 
});
