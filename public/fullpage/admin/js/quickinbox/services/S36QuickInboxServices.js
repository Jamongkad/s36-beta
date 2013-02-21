angular.module('S36QuickInboxServices', [])
.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};

    shared_service.change_feedback_state = function(feed_status, feeds) {         
        $.ajax({
            type: 'POST'    
          , data: { 'status': feed_status, 'feeds': feeds }
          , url: '/hosted/change_feedback_state'
          , success: function(data) {  
                console.log(data);
            }
        });
    }
 
    return shared_service;
});
