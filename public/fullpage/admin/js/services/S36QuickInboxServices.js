angular.module('S36QuickInboxServices', [])
.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};

    shared_service.info_block_behavior = function(cb) { 
        $('.delete-block').unbind('click.delete-block').bind('click.delete-block', function(e) {
            console.log('Delete Media Id: ' + $(this).attr('mid'));
        });
    }

    shared_service.change_feedback_state = function(id, state) {
        console.log("Changing State: " + state + " Changing Id:" + id);
    }
 
    return shared_service;
});
