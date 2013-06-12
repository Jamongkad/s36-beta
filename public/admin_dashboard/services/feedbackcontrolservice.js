angular.module('Services', [])
.service('FeedbackControlService', function($rootScope) { 
    var shared_service = {};
    shared_service.feedid;

    shared_service.set_id = function(id) {
        shared_service.feedid = id;
    }

    shared_service.get_id = function() {
        return shared_service.feedid;
    }

    return shared_service;
})
