var app = angular.module("QuickInbox", []);

app.controller("AppCtrl", function($scope) {
    
    var feedback = [
        {"feedid": 285, "text": "Mathew is Kewl!"} 
      , {"feedid": 286, "text": "Mathew is Hot!"} 
    ];

    this.fetch_inbox_feeds = function() {
        return feedback;     
    }

    this.say_hi = function() {
        alert("Mathew");
    }

    return $scope.AppCtrl = this;
});
