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
          , async: false
          , url: '/feedback/change_feedback_state'
          , success: function(msg) {
                shared_service.jsonmsg = msg; 
            }
        }); 
        
        shared_service.bust_hostfeed_data();
    }

    shared_service.bust_hostfeed_data = function() {
        $.ajax({
            type: 'get'    
          , url: '/feedback/bust_hostfeed_data'
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

    shared_service.set_data = function(data) {
        this.data = data; 
    }

    shared_service.get_data = function() { 
        return this.data;
    }

    shared_service.broadcast_now = function() {
        $rootScope.$broadcast('checkFeedbackStatus');
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

    shared_service.set_inbox_as_read = function(type) {
        $.ajax({
            type: 'POST'    
          , dataType: 'json'
          , data: { type: type }
          , url: '/feedback/mark_inbox_as_read'
          , success: function(data) {
                if(data.type == "msg") {
                    window.location.href = '/inbox/all';     
                }

                if(data.type == "msg_ap") {
                    window.location.href = '/inbox/published/all';     
                } 
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
