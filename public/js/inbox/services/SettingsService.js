angular.module('Services', [])
.service('MessageService', function($rootScope) {

    var shared_service = {};
    shared_service.message;
    shared_service.pushdata;
    shared_service.editdata;

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

    shared_service.fetch_reply_messages = function() {
        shared_service.get_messages('msg');
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
    
    shared_service.delete_msg = function(msg_obj) {
        $.ajax({
            url: "/message/delete_msg"  
          , type: 'POST'
          , data: msg_obj
          , async: false
          , dataType: 'json'
        });      
    }

    shared_service.register_request_message = function()  {
        $rootScope.$broadcast('addRequestMessage');
    }

    shared_service.register_reply_message = function()  {
        $rootScope.$broadcast('fetchReplyMessage');
    }
    
    return shared_service;
});
