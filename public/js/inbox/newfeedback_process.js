function newfeedback_process(collection) {
    console.log(collection);   
    $.ajax({   
        type: "POST"      
      , data: { "feedids": collection } 
      , url: "/feedback/redis_feedback_process" 
      , success: function() {
            $.ajax({
                type: 'GET'    
              , dataType: 'json'
              , async: false
              , url: '/feedback/get_feedback_count'
              , success: function(data) {
                    console.log(data) 
                }
            });
        }
    });
}
