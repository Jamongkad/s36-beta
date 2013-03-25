angular.module('FormServices', [])
.service('Data', function($rootScope) { 
    var shared_service = {};

    shared_service.title;
    shared_service.feedbacktext;
    shared_service.firstname;
    shared_service.lastname;
    return shared_service;
});
