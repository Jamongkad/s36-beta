angular.module('S36QuickInboxServices', [])
.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};

    shared_service.change_feedback_state = function(id, state) {
        console.log("Changing State: " + state + " Changing Id:" + id);
    }
 
    return shared_service;
});
