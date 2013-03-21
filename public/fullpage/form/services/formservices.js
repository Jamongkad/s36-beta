angular.module('FormServices', [])
.service('Data', function($rootScope) { 
    var shared_service = {};
    shared_service.message = "Mathew Wong RULES!";
    return shared_service;
});
