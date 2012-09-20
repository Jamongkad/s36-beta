angular.module('S36Module', [])
.service('MessageService', function($rootScope) {

    var shared_service = {};
    shared_service.message;

    $.ajax({
        type: 'GET'    
      , dataType: 'json'
      , async: false
      , url: 'message/get_msgs'
      , data: {"type": "msg"}
      , success: function(data) {
            shared_service.message = data;
        }
    });

    return shared_service;
})
.service('RequestMessageService', function($rootScope) {
    var shared_service = {};

    shared_service.message;

    $.ajax({
        type: 'GET'    
      , dataType: 'json'
      , async: false
      , url: 'message/get_msgs'
      , data: {"type": "rqs"}
      , success: function(data) {
            shared_service.message = data;
        }
    });

    return shared_service; 
})
