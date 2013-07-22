angular.module('Category', [])
.service('Category', function($rootScope) {

    var shared_service = {};

    shared_service.fetch = function() {
        var data; 
        $.ajax({ 
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/rest/category'
          , success: function(msg) {
                data = msg;
            }
        });

        return data;
    }

    shared_service.modify = function(data) { 
        $.ajax({ 
            type: 'POST'    
          , dataType: 'json'
          , data: data
          , url: '/settings/rename_ctgy'
        });
    }

    shared_service.delete = function(id) {
        $.ajax({ 
            type: 'POST'    
          , dataType: 'json'
          , data: {ctgy_id: id}
          , url: '/settings/delete_ctgy'
        });  
    }
    return shared_service;
});
