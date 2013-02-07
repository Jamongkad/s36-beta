angular.module('feedback', [])
.directive('feedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback;

            if(feedback.msg) {
                $(element).html("<sup class='count'>" + feedback.msg + "</sup>");
            }   
        }
    }    
})
.directive('inboxclick', function(SettingsService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {

           var process = function(e) {
               e.stopImmediatePropagation();
               //SettingsService.set_inbox_as_read($(location).attr('pathname'));
               console.log('mathew');
               return false;
           };

           $(element).children().click(function(e) {
               e.stopImmediatePropagation();
               //SettingsService.set_inbox_as_read($(location).attr('pathname'));
               console.log('mathew');
               return false;
           };);
           $(element).click(function(e) {
               e.stopImmediatePropagation();
               //SettingsService.set_inbox_as_read($(location).attr('pathname'));
               console.log('mathew');
               return false;
           };);
        }
    }    
    
})
