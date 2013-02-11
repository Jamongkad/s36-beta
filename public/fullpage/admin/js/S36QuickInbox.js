var app = angular.module("QuickInbox", []);

app.controller("AppCtrl", function($scope) {
    
    var feedback = [
        {   "feedid": 285
          , "text": "Mathew is Kewl!"
          , "media": [  
                { "media_id": 280, "text": "Video + (girl, girl)" }
              , { "media_id": 288, "text": "Video + (boy, boy)" }
            ]
        } 
      , {  "feedid": 286
         , "text": "Mathew is Hot!"
         , "media": [
                { "media_id": 280, "text": "Video + (girl)" }
              , { "media_id": 288, "text": "Video + (boy)" }
            ]
        } 
    ];

    this.fetch_inbox_feeds = function() {
        return feedback;     
    }

    this.say_hi = function() {
        alert("Mathew");
    }

    return $scope.AppCtrl = this;
});
