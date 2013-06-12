angular.module('Services', [])
.service('FeedbackControlService', function($rootScope) { 
    var shared_service = {};
    shared_service.feedid;
    return shared_service;
})
