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
                }, 5000);
            }
        });

    })();

    $scope.say_hi = function() {
        alert("Mathew");
    }

});


app.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};
    shared_service.message;

    shared_service.fetch_inbox_feeds = function() { 
        feed_request();
    }

    shared_service.register = function()  {
        $rootScope.$broadcast('fetchInboxFeeds');
    }

    function feed_request() { 
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/hosted/quick_inbox'
          , success: function(data) {
                shared_service.message = data;
                setTimeout(function() { feed_request(); }, 15000);
            }
        });
    }
    
    return shared_service;
});
