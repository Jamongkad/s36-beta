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
          , success: function(data) {
                shared_service.data = data;
            }
        }); 

        this.broadcast_now();
    }

    shared_service.set_data = function(data) {
        this.data = data; 
    }

    shared_service.get_data = function() { 
        return this.data;
    }

    shared_service.broadcast_now = function() {
        $rootScope.$broadcast('checkFeedbackStatus');
    }

    return shared_service;
})