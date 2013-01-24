angular.module('Services', [])
.service('FeedbackService', function($rootScope) {

    var shared_service = {};
    shared_service.feedback_count;

    shared_service.get_feedback_count = function() { 
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/feedback/get_feedback_count'
          , success: function(data) {
                shared_service.feedback_count = data;
            }
        });
    }

    shared_service.register_feedback_count = function()  {
        $rootScope.$broadcast('requestFeedbackCount');
    }

    return shared_service;
});
