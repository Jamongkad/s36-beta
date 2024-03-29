var app = angular.module("QuickInbox", ['S36QuickInboxDirectives', 'S36QuickInboxServices', 'CompileHtml']);
app.controller("AppCtrl", function($scope, $compile, QuickInboxService) {

    $scope.feedbacks = [];
    $scope.selected = [];

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
                }, 10000);   

                $scope.feedbacks = data;
                $scope.$apply($scope.feedbacks);
            }
        });

        $('#adminWindowHolder').unbind('mouseenter.widget').bind('mouseenter.widget', function() { 
            timer.pause();
            console.log("Stopping Poll");
        });

        $('#adminWindowHolder').unbind('mouseleave.widget').bind('mouseleave.widget', function() { 
            timer.resume();
            console.log("Starting Poll");
        });
    })();


    $scope.admin_action = function(mystatus) {
        QuickInboxService.change_feedback_status(mystatus, $scope.selected);
        //implementation is too buggy
        //QuickInboxService.render_feeds(mystatus, $scope.selected);
        $scope.selected = []; 
    }

    $scope.check_select_length = function() { 
        if($scope.selected.length > 0) {
            $("#quickInboxActions").show();
        } else { 
            $("#quickInboxActions").hide();
        }
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
