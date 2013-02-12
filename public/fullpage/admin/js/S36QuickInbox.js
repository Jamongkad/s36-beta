var app = angular.module("QuickInbox", []);

app.controller("AppCtrl", function($scope, $http, $timeout, QuickInboxService) {

    $scope.feedbacks = [];

    (function feed_request() { 
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/hosted/quick_inbox'
          , success: function(data) {  
                $scope.feedbacks = data;
                $scope.$apply($scope.feedbacks);
                setTimeout(function() { 
                    feed_request();  
                    $('.widget-list').jScrollPane();
                }, 10000);
            }
        });
    })();

});


app.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};
    shared_service.message;

    shared_service.fetch_inbox_feeds = function(cb) { 
         
    }
 
    return shared_service;
});
