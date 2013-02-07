angular.module('feedback', [])
.controller('FeedbackCountCtrl', function($scope) { 
    $scope.call_count = function(count) {
        alert("Mathew " + count);
    }
})
.directive('feedbackcount', function() {
    return {
        restrict: 'A'     
      , scope: {
            countme: '&'   
        }
      , template:  '<input type="text" ng-model="count">'
                 + '<div class="button" ng-click="countme({fdbackcount:count})">Call Count!</div>'
      /*
      , link: function(scope, element, attrs) {
            $(element).bind('mouseover', function(e) {
                console.log("Pwet"); 
            });
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback_count;

            if(feedback.checked) {
                $(element).html("<sup class='count'>" + feedback.feedback_count + "</sup>");     
            }
       
        }
       */
    }    
})
