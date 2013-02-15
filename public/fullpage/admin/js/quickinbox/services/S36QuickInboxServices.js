angular.module('S36QuickInboxServices', [])
.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};

    shared_service.change_feedback_state = function(id, state) {
        console.log("Changing State: " + state + " Changing Id:" + id);
         
        $.ajax({
            type: 'POST'    
          , data: {'state': state, 'feedid': id}
          , url: '/hosted/change_feedback_state'
          , success: function(data) {  
                console.log(data);
            }
        });
    }
 
    return shared_service;
});
