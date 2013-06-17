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
    return shared_service;
})
