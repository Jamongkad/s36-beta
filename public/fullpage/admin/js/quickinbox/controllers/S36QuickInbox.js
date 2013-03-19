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
                }, 25000);   

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

    $scope.update_selected = function(action, id) {
        if (action == 'add' & $scope.selected.indexOf(id) == -1)
            $scope.selected.push(id);
        if (action == 'remove' && $scope.selected.indexOf(id) != -1)
            $scope.selected.splice($scope.selected.indexOf(id), 1);
    }
 
    $scope.update_selection = function($event, feed) {
        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');
        $scope.update_selected(action, feed);
        $scope.check_select_length();
        
        if(checkbox.checked) { 
            $(checkbox).parents('.widget-item').css({'background-color': '#FAFAFA'});     
        } else {
            $(checkbox).parents('.widget-item').css({'background-color': '#FFF'});     
        }
       
    }

    $scope.is_selected = function(id) {
        return $scope.selected.indexOf(id) >= 0;   
    }

    $scope.admin_action = function(mystatus) {
        //QuickInboxService.change_feedback_status(mystatus, $scope.selected);
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
