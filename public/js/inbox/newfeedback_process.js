function newfeedback_process(collection) {
    console.log(collection);   
    $.ajax({   
        type: "POST"      
      , data: { "feedids": collection } 
      , url: "/feedback/redis_feedback_process" 
    });
}
