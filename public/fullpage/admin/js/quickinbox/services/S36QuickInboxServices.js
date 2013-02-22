angular.module('S36QuickInboxServices', [])
.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};

    shared_service.preview_feeds = function(feed_status, feeds) {         
        $.ajax({
            type: 'POST'    
          , dataType: 'json'
          , data: { 'status': feed_status, 'feeds': feeds }
          , url: '/hosted/preview_feeds'
          , success: function(data) {  
                console.log(data);
                //$("#feedbackContainer").html(data);
            }
        });
    }
 
    return shared_service;
});
