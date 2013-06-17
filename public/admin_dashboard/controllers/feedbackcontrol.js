function FeedbackControl($scope, FeedbackControlService, FeedbackSignal) { 

    $scope.selected = [];

    $scope.feedback_status = function(id, feed_status) { 
        console.log(feed_status + " id: " + id);
        FeedbackSignal.prep_status_message(feed_status)
        FeedbackControlService.change_status(id, feed_status);
    }

    $scope.reply_feedback = function(id) {
        console.log("reply id:" + id);
    }

    $scope.is_selected = function(id) {
        return $scope.selected.indexOf(id) >= 0;   
    }

    $scope.update_selected = function(action, id) {
        /*
        if (action == 'add' && $scope.selected.indexOf(id) == -1) {
            $scope.selected.push(id);     
        }
       
        if (action == 'remove' && $scope.selected.indexOf(id) != -1) {
            $scope.selected.splice($scope.selected.indexOf(id), 1);     
        } 
        */

        if (action == 'add') {
            $scope.selected.push(id);     
        }
       
    }

    $scope.update_selection = function($event, feed) {

        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');

        $("input[type=checkbox][name=feedid]").unbind('change.select').bind('change.select', function() { 
            console.log($(this).val());
            console.log(action);
            //$scope.update_selected(action, $(this).val()); 
            $scope.selected.push($(this).val());     
            console.log($scope.selected);
        });

        if(checkbox.checked) { 
            $(checkbox).parents('.dashboard-feedback').css({'background-color': '#F1F1f1'});     
        } else {
            $(checkbox).parents('.dashboard-feedback').css({'background-color': '#FFF'});     
        } 

    }
}

function CheckyBox($scope, FeedbackSignal) { 
    $scope.$on('checkFeedbackStatus', function() {
        $scope.status_selection = FeedbackSignal.feed_status;
    });
}
