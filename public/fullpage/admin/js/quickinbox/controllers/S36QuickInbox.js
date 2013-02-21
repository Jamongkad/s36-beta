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
                    $('.widget-list').jScrollPane();
                }, 10000); 
                $scope.feedbacks = data;
                $scope.$apply($scope.feedbacks); 
            }
        });

        $('#quickInbox').unbind('mouseenter.widget').bind('mouseenter.widget', function() { 
            timer.pause();
            console.log("Stopping Poll");
        });

        $('#quickInbox').unbind('mouseleave.widget').bind('mouseleave.widget', function() { 
            timer.resume();
            console.log("Starting Poll");
        });
    })();

    var update_selected = function(action, id) {
        if (action == 'add' & $scope.selected.indexOf(id) == -1)
            $scope.selected.push(id);
        if (action == 'remove' && $scope.selected.indexOf(id) != -1)
            $scope.selected.splice($scope.selected.indexOf(id), 1);
    }

    
    $scope.update_selection = function($event, id) {
        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');
        update_selected(action, id);
    }

    $scope.is_selected = function(id) {
        return $scope.selected.indexOf(id) >= 0;   
    }

    $scope.get_selected_class = function(entity) {
        console.log(entity);
    }

    $scope.publish = function() {
        /*
        $scope.published = id;
        QuickInboxService.change_feedback_state(id, 'publish');
        */
        console.log($scope.selected);
    }

    $scope.feature = function() { 
        /*
        $scope.featured = id;
        QuickInboxService.change_feedback_state(id, 'feature');
        */
    }

    $scope.delete = function() {
        /*
        $scope.deleted = id;
        QuickInboxService.change_feedback_state(id, 'delete');
        */
    }

    $scope.undo_action = function() {
        /*
        $scope.undo = id;
        QuickInboxService.change_feedback_state(id, 'restore'); 
        */
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
