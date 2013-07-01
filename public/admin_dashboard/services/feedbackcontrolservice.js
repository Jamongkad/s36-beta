angular.module('Services', [])
.service('FeedbackControlService', function($rootScope) { 
    var shared_service = {};

    shared_service.change_status = function(status_change, flag) {

        var undo_flag; 
        if(flag == true) {
            undo_flag = false;
        } else { 
            undo_flag = true;
        }

        $.ajax({
            type: 'post'    
          , dataType: 'json'
          , data: { feed_data: status_change, undo: undo_flag }
          , url: '/feedback/change_feedback_state'
        }); 
    }

    shared_service.flag_feedback = function(status_change) {
        $.ajax({
            type: 'post'    
          , dataType: 'json'
          , data: { feed_data: status_change }
          , url: '/feedback/flagfeedback'
        }); 
    }

    shared_service.expunge = function() {
        this.broadcast_now(); 
    }

    shared_service.broadcast_now = function() { 
        $rootScope.$broadcast('expungeFeedId');
    }

    return shared_service;
})
.service('FeedbackSignal', function($rootScope) {     

    var shared_service = {};
 
    shared_service.data;

    shared_service.current_state = function(data) {
        this.data = data; 
        this.broadcast_now();
    }

    shared_service.broadcast_now = function() {
        $rootScope.$broadcast('checkFeedbackStatus');
    }

    return shared_service;
})
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

    shared_service.register_request_message = function()  {
        $rootScope.$broadcast('fetchRequestMessage');
    }

    shared_service.register_reply_message = function()  {
        $rootScope.$broadcast('fetchReplyMessage');
    }
    
    shared_service.register_replybody = function()  {
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

    shared_service.send_fastforward = function(email, feedid) { 
        $.ajax({
            type: 'POST'    
          , data: {email: email, feedid: feedid}
          , url: '/feedback/fastforward'
          , success: function() {      
                alert("Fast-forward sent to " + email);
            }
        });
    }

    shared_service.inline_change = function(feed_status, feedid, status_type) {
        var url;
        if(status_type == 'status') {
            url = "/feedback/changestatus";
        } else {
            url = "/feedback/changepriority";
        }
        $.ajax({
              type: "POST"
            , url: url
            , data: {"select_val": feed_status, "feed_id": feedid}
        });  
    }

    return shared_service;
})
