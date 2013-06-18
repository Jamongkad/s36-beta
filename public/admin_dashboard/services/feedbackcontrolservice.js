angular.module('Services', [])
.service('FeedbackControlService', function($rootScope) { 
    var shared_service = {};

    shared_service.change_status = function(id, feed_status) {
        console.log("Changing DB id: " + id);
        console.log("Changing DB status: " + feed_status);
    }

    return shared_service;
})
.service('FeedbackSignal', function($rootScope) {     

    var shared_service = {};
 
    shared_service.feed_status;
    shared_service.feed_id;

    shared_service.set_status_message = function(msg) {
        this.feed_status = msg;     
        this.broadcast_now();
    }

    shared_service.set_feed_id = function(id) { 
        this.feed_id = id;     
        this.broadcast_now();
    }

    shared_service.broadcast_now = function() {
        $rootScope.$broadcast('checkFeedbackStatus');
    }

    return shared_service;
})
