function FeedbackControl($scope, FeedbackControlService, FeedbackSignal) { 

    $scope.selected = [];
    $scope.checkboxes = $("input[type=checkbox][name=feedid]");

    var update_selected = function(action, id) {

        if (action == 'add' && $scope.selected.indexOf(id) == -1) {
            $scope.selected.push(id);     
        }
       
        if (action == 'remove' && $scope.selected.indexOf(id) != -1) {
            $scope.selected.splice($scope.selected.indexOf(id), 1);     
        } 

    }

    $scope.feedback_status = function(id, feed_status) { 
        console.log(feed_status + " id: " + id);

        FeedbackSignal.set_status_message(feed_status)
        FeedbackSignal.set_feed_id(id);

        FeedbackControlService.change_status(id, feed_status);
    }

    $scope.reply_feedback = function(id) {
        console.log("reply id:" + id);
    }

    $scope.update_selection = function($event, feed) {

        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');

        update_selected(action, feed); 

        if(checkbox.checked) { 
            $(checkbox).parents('.dashboard-feedback').css({'background-color': '#F1F1f1'});     
        } else {
            $(checkbox).parents('.dashboard-feedback').css({'background-color': '#FFF'});     
        } 

    }

    $scope.select_all = function($event) { 
        
        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');

        for(var i=0; i < $scope.checkboxes.length; i++) {
            var entity = $($scope.checkboxes[i]);

            if(action == "add") {
                entity.prop("checked", true);     
            } else { 
                entity.prop("checked", false);     
            }
           
            update_selected(action, parseInt(entity.val(), 10)); 
        }
    }

    $scope.is_selected = function(id) {
        return $scope.selected.indexOf(id) >= 0;   
    }

    $scope.is_selected_all = function() {
        return $scope.selected.length === $scope.checkboxes.length;
    }
}

function CheckyBox($scope, FeedbackSignal) { 

    $scope.status_selection;
    $scope.feed_id;

    $scope.undo = function() {
        console.log("Undo id: " + $scope.feed_id);
    }

    $scope.$on('checkFeedbackStatus', function() {
        $scope.status_selection = FeedbackSignal.feed_status;
        $scope.feed_id = FeedbackSignal.feed_id;
    });
}
