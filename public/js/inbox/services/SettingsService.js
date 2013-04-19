angular.module('Services', [])
.service('MessageService', function($rootScope) {

    var shared_service = {};
    shared_service.message;
    shared_service.msgdata;
    shared_service.pushdata;
    shared_service.editdata;

    shared_service.replybody;

    shared_service.get_replybody = function() {
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/feedback/get_replybody'
          , success: function(data) {
                shared_service.replybody = data;
            }
        });
        
    }

    shared_service.get_messages = function(type) { 
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/message/get_msgs'
          , data: {"type": type}
          , success: function(data) {
                shared_service.message = data;
            }
        });
    }

    shared_service.fetch_messages = function(msgtype) {
        shared_service.get_messages(msgtype);
    }

    shared_service.save = function(msg_obj) {    
        $.ajax({
            url: "/message/save_msg"  
          , type: 'POST'
          , data: msg_obj
          , async: false
          , dataType: 'json'
          , success: function(data) {
                shared_service.pushdata = data;             
            }
        });
    }

    shared_service.update = function(msg_obj) {
        $.ajax({
            url: "/message/update"  
          , type: 'POST'
          , data: msg_obj 
          , async: false
          , dataType: 'json'
          , success: function(data) {
                shared_service.editdata = data;
            }
        }); 
    }
 
    shared_service.get_message = function(id, type) {
        $.ajax({
            url: "/message/get_msg"  
          , type: 'GET'
          , data: { id: id, type: type }
          , async: false
          , dataType: 'json'
          , success: function(data) {
                shared_service.msgdata = data;
            }
        });      
    }

    shared_service.register_request_message = function()  {
        $rootScope.$broadcast('addRequestMessage');
    }

    shared_service.register_reply_message = function()  {
        $rootScope.$broadcast('fetchReplyMessage');
    }
    
    shared_service.register_reply_body = function()  {
        $rootScope.$broadcast('fetchReplyBody');
    }
    
    return shared_service;
})
.service('FeedbackService', function($rootScope) {

    var shared_service = {};

    shared_service.feedback;

    shared_service.get_feedback_count = function() { 
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/feedback/get_feedback_count'
          , success: function(data) {
                shared_service.feedback = data;
            }
        });
    }

    shared_service.set_inbox_as_read = function(pathname) {
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/feedback/mark_inbox_as_read'
          , success: function(data) {
                window.location.href = '/inbox/all';
            }
        });
    }

    return shared_service;
});
