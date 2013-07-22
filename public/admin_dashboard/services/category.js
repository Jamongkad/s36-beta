angular.module('Category', [])
.service('Category', function($rootScope) {

    var shared_service = {};

    shared_service.fetch = function() {
        console.log('Ok');
        $.ajax({ 
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/rest/category'
          , success: function(msg) {
                console.log(msg);
            }
        });
    }

    return shared_service;
});
