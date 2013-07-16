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

    shared_service.flag_feedback = function(data) { 
        $.ajax({
            type: 'post'    
          , dataType: 'json'
          , data: { 'feed_data': data }
          , url: '/feedback/flagfeedback'
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
        console.log("Broadcasting...");
        $rootScope.$broadcast('checkFeedbackStatus');
    }

    return shared_service;
})
