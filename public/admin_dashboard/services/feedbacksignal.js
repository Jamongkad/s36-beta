angular.module('FeedbackSignal', [])
.service('FeedbackSignal', function($rootScope) {     

    var shared_service = {};
 
    shared_service.data;

    shared_service.current_state = function(data) {

        $.ajax({
            type: 'POST'    
          , dataType: 'json'
          , data: {'data': data}
          , async: false
          , url: '/feedback/set_current_feedback_state'
        }); 

        this.broadcast_now();
    }

    shared_service.get_data = function() { 

        var result;
        $.ajax({
            type: 'POST'    
          , dataType: 'json'
          , async: false
          , url: '/feedback/get_current_feedback_state'
          , success: function(data) {
                result = data;
            }
        }); 

        return result;
    }

    shared_service.broadcast_now = function() {
        $rootScope.$broadcast('checkFeedbackStatus');
    }

    return shared_service;
})
