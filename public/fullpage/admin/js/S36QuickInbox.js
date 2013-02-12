var app = angular.module("QuickInbox", []);

app.controller("AppCtrl", function($scope, $http, $timeout, QuickInboxService) {

    $scope.feedbacks = [];
    $scope.selection = [];

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

    $scope.publish = function(id) {
        alert("Publishing! " + id);
    }

    $scope.feature = function(id) { 
        alert("Featuring! " + id);
    }

    $scope.metadata_block = function(data) {
        if(data.hasOwnProperty('metadata')) { 
            for(var i=0; i<data.length; i++) {
                console.log(data[i].key);
                console.log(data[i].value);
            }
            /*
            var template = '<div class="custom-meta-list grids">'
            for(var i=0; i<data.length; i++) {
                template =+ '<div class="custom-meta">'           
                template =+ '<div class="custom-meta-name">' + data[i].key + ' : <span class="value">' + data[i].value + '</span></div>'
                template =+ '</div>'
            }
            template =+ '</div>';
            return template;
            */
        }
    }

});


app.service('QuickInboxService', function($rootScope) {
    
    var shared_service = {};
    shared_service.message;

    shared_service.fetch_inbox_feeds = function(cb) { 
         
    }
 
    return shared_service;
});
