angular.module('feedbackcontrol', [])
.directive('transform', function(FeedbackControlService, $compile) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) { 
                var me = $(element)
                me.parents('.dashboard-feedback').fadeOut(500, function() {

                    var child_count = $(me).parents('.feedback-group').children('.dashboard-feedback:visible');
                    if(child_count.length == 0) {
                        $(me).parents('.feedback-group').fadeOut(500);
                    }      

                }); 
                console.log("Mathew clicked");
                $(".checky-box-container").show();
            });
        } 
    }    
})
.directive('undo', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind("click", function() {
                console.log("Mathew is Kewl");
            });
        }
    }    
})
.directive('closeChecky', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind("click", function() {
                console.log("Mathew is Awesome");
            }); 
        }
    }    
})
