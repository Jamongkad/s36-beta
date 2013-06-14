angular.module('Services', [])
.service('FeedbackControlService', function($rootScope) { 
    var shared_service = {};

    shared_service.change_status = function(id) {
        console.log("Changing Status id:" + id);
    }

    return shared_service;
})
