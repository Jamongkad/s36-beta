angular.module('PublicTemplate', [])
.service('Template', function() { 

    //all data coming from serverside html templates
    var shared_service = {} 
    shared_service = backend_vars;
    return shared_service;
});
