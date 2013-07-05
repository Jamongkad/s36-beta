angular.module('ModifyFeedback', [])
.service('ModifyFeedback', function() {
    
    var shared_service = {} 
    shared_service.edit_feedback_text = function(data) {
        $.ajax({
            url: '/feedback/edit_feedback_text'              
          , type: 'POST'
          , dataType: 'json'
          , data: data 
          , success: function(msg) { 
                if(msg.saved == 1) {
                    alert("Feedback text successfully edited.");     
                } 
            }
        }); 
    }

    shared_service.lock_feedback_display = function(data) {
        $.ajax({
            url: '/feedback/lock_feedback_display'              
          , type: 'POST'
          , data: data 
        });         
    }

    shared_service.display_toggle = function(data) { 
        $.ajax({
            url: '/feedback/toggle_feedback_display'           
          , type: 'POST'
          , data: data 
        });         
    }

    return shared_service;
})
