angular.module('feedback', [])
.directive('myFeedbackcount', function(FeedbackService) {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('mouseover', function(e) {
                console.log("Pwet"); 
            });
            /*
            FeedbackService.get_feedback_count();
            var feedback = FeedbackService.feedback_count;

            if(feedback.checked) {
                $(element).html("<sup class='count'>" + feedback.feedback_count + "</sup>");     
            }
            */ 
        }
    }    
})
.controller('ChoreCtrl', function($scope) {
    $scope.log_chore = function(chore) {
        console.log(chore + " is done!");
    }
})
.directive('kid', function() { 
    return {
        restrict: 'E'     
      , scope: {
            done:"&" 
        }
      , template: '<input type="text" ng-model="chore"/> {{chore}}' + 
                  '<div class="button" ng-click="done({chore:chore})">Me done!</div>'
    }
})
