var app = angular.module("QuickInbox", ['S36QuickInboxDirectives', 'S36QuickInboxServices', 'CompileHtml']);

app.controller("AppCtrl", function($scope, $compile, QuickInboxService) {

    $scope.feedbacks = [];

    $scope.featured;
    $scope.published;
    $scope.deleted;
    $scope.undo;

    var timer;  

    (function feed_request() { 
        $.ajax({
            type: 'GET'    
          , dataType: 'json'
          , async: false
          , url: '/hosted/quick_inbox'
          , success: function(data) {  
                timer = new Timer(function() { 
                    feed_request();  
                    $('.widget-list').jScrollPane();
                }, 30000); 
                $scope.feedbacks = data;
                $scope.$apply($scope.feedbacks); 
            }
        });

        $('#quickInbox').unbind('mouseenter.widget').bind('mouseenter.widget', function() { 
            timer.pause();
            console.log("Stopping");
        });

        $('#quickInbox').unbind('mouseleave.widget').bind('mouseleave.widget', function() { 
            timer.resume();
            console.log("Starting");
        });
    })();

    $scope.publish = function(id) {
        $scope.published = id;
        QuickInboxService.change_feedback_state(id, 'publish');
    }

    $scope.feature = function(id) { 
        $scope.featured = id;
        QuickInboxService.change_feedback_state(id, 'feature');
    }

    $scope.delete = function(id) {
        $scope.deleted = id;
        QuickInboxService.change_feedback_state(id, 'delete');
    }

    $scope.undo_action = function(id) {
        $scope.undo = id;
        QuickInboxService.change_feedback_state(id, 'undo'); 
    }

    $scope.test_punch = function(data) {
        console.log(data);
    }

});

function Timer(callback, delay) {

    var timerId, start, remaining = delay;

    this.pause = function() {
        window.clearTimeout(timerId);
        remaining -= new Date() - start;
    };

    this.resume = function() {
        start = new Date();
        timerId = window.setTimeout(callback, remaining);
    };

    this.resume();        
}
