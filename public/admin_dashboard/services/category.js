angular.module('Category', [])
.service('Category', function($rootScope) {

    var shared_service = {};
    shared_service.cat_data;
    shared_service.write_result;

    shared_service.write = function(ctgy_nm) { 
        $.ajax({ 
            type: 'POST'    
          , dataType: 'json'
          , async: false
          , data: { ctgy_nm: ctgy_nm }
          , url: '/settings/write_ctgy'
          , success: function(msg) {
                shared_service.write_result = msg;
            }
        });
        this.broadcast_now();
    }

    shared_service.fetch = function() {
        $.ajax({ 
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/rest/category'
          , success: function(msg) {
                shared_service.cat_data = msg;
            }
        });
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
          , async: false
          , data: {ctgy_id: id}
          , url: '/settings/delete_ctgy'
        });  
        this.broadcast_now();
    }

    shared_service.broadcast_now = function() { 
        $rootScope.$broadcast('fetchCategory');
    }

    return shared_service;
});
