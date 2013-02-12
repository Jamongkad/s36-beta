var app = angular.module("QuickInbox", []);

app.controller("AppCtrl", function($scope, QuickInboxService) {
    QuickInboxService.register();
    var feeds = QuickInboxService.fetch_inbox_feeds().message;

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

    this.fetch_inbox_feeds = function() {
        return feeds;
    }

    this.say_hi = function() {
        alert("Mathew");
    }

    //Broadcast Messages
    $scope.$on('fetchInboxFeeds', function()  {
        $scope.$apply(function() {
            feeds = QuickInboxService.fetch_inbox_feeds().message;
        })
    });

    return $scope.AppCtrl = this;
});


app.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};
    shared_service.message;
    shared_service.pushdata;
    shared_service.editdata;

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
