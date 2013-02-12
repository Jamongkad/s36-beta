var app = angular.module("QuickInbox", []);

app.controller("AppCtrl", function($scope, $http, $timeout, QuickInboxService) {

    $scope.feedbacks = [];

    (function feed_request() { 

        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/hosted/quick_inbox'
          , cache: false
          , success: function(data) {  
                $scope.feedbacks = data;
                $scope.$apply($scope.feedbacks);
                setTimeout(function() { feed_request(); }, 5000);
            }
        });

        /*
        $http.get('/hosted/quick_inbox').success(function(data) {
            $scope.feedbacks = data;
            $timeout(feed_request, 5000);
        })
        */
    })();
    /*
    var feedback = [
        {   "feedid": 285
          , "text": "Mathew is Kewl!"
          , "name": "Mathew Wong" 
          , "media": [  
                { "media_id": 280, "text": "Video + (girl, girl)" }
              , { "media_id": 288, "text": "Video + (boy, boy)" }
            ]
        } 
      , {  "feedid": 286
         , "name": "Irene Paredes"
         , "text": "Mathew is Hot!"
         , "media": [
                { "media_id": 280, "text": "Video + (girl)" }
              , { "media_id": 288, "text": "Video + (boy)" }
            ]
        } 
    ];
    */
    /*
    this.fetch_inbox_feeds = function() {
        return $scope.feeds;
    }
    */

    this.say_hi = function() {
        alert("Mathew");
    }

    return $scope.AppCtrl = this;
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
