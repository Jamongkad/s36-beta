angular.module('FeedbackSignal', [])
.service('FeedbackSignal', function($rootScope) {     

    var shared_service = {};
 
    shared_service.data;

    shared_service.current_state = function(data) {
        /*
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
        */
        console.log("setting data");
        console.log(data);
        this.data = data;

        this.broadcast_now();

    }

    shared_service.get_data = function() { 
        /*
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
        */
        console.log("getting data");
        console.log(this.data);
        return this.data;
    }

    shared_service.broadcast_now = function() {
        $rootScope.$broadcast('checkFeedbackStatus');
    }

    return shared_service;
})
