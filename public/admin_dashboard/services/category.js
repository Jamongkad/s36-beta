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

    return shared_service;
});
