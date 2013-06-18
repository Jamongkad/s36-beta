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

    var highlight = function(entity) {
        if(entity.checked) { 
            $(entity).parents('.dashboard-feedback').css({'background-color': '#F1F1f1'});     
        } else {
            $(entity).parents('.dashboard-feedback').css({'background-color': '#FFF'});     
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
        highlight(checkbox);
        /*
        if(checkbox.checked) { 
            $(checkbox).parents('.dashboard-feedback').css({'background-color': '#F1F1f1'});     
        } else {
            $(checkbox).parents('.dashboard-feedback').css({'background-color': '#FFF'});     
        } 
        */
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
            //highlight(checkbox);
            console.log(entity);
        }
    }
}

function CheckyBox($scope, FeedbackSignal) { 

    $scope.status_selection;
    var feed_id;

    $scope.undo = function() {
        console.log("Undo ID: " + feed_id);
    }

    $scope.$on('checkFeedbackStatus', function() {
        $scope.status_selection = FeedbackSignal.feed_status;
        feed_id = FeedbackSignal.feed_id;
    });
}
