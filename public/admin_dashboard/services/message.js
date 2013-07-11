angular.module('MessageService', [])
.service('MessageService', function($rootScope) {

    var shared_service = {};
    shared_service.message;
    shared_service.msgdata;
    shared_service.pushdata;
    shared_service.editdata;

    shared_service.replybody;

    shared_service.get_replybody = function(feedid) {
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , data: {feedid: feedid}
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
          , data: { "type": type }
          , success: function(data) {
                shared_service.message = data;
                console.log(data);
                shared_service.register_reply_message();
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
                console.log(data);
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

    shared_service.delete_msg = function(id, type) { 
        $.ajax({
            url: "/message/delete_msg"  
          , type: 'POST'
          , data: { id: id, type: type }
          , dataType: 'json'
        });      
    }

    shared_service.send_email = function(data, success_callback) {
        $.ajax({
            url: "/feedback/reply_to"  
          , type: 'POST'
          , data: { email: data }
          , success: success_callback
        });       
    }

    shared_service.send_request_email = function(data, success_callback) {
        $.ajax({
            url: "/feedback/requestfeedback"  
          , type: 'POST'
          , data: { email: data }
          , success: success_callback
        });       
    }

    shared_service.register_reply_message = function()  {
        $rootScope.$broadcast('fetchReplyMessage');
    }
    
    shared_service.register_replybody = function()  {
        $rootScope.$broadcast('fetchReplyBody');
    }
    
    return shared_service;
})
