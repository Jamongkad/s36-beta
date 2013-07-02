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
                if(msg.save == 1) {
                    alert("Feedback text successfully edited!");     
                } 
            }
        }); 
    }

    return shared_service;
})
