angular.module('S36Module', []).factory('mySettingsService', function($rootScope) {

    var shared_service = {};
    shared_service.message;

    $.ajax({
        type: 'GET'    
      , dataType: 'json'
      , async: false
      , url: 'settings/get_msgs'
      , success: function(data) {
            shared_service.message = data;
        }
    });

    return shared_service;
});
