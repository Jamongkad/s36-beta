function FeedbackControl($scope, FeedbackControlService, FeedbackSignal, Template) { 

    $scope.selected = [];
    $scope.checkboxes = $(".feed-checkbox");
    $scope.status_select_value = 'none';

    var update_selected = function(action, id) {
        if (action == 'add' && $scope.selected.indexOf(id) == -1) {
            $scope.selected.push(id);     
        }
       
        if (action == 'remove' && $scope.selected.indexOf(id) != -1) {
            $scope.selected.splice($scope.selected.indexOf(id), 1);     
        } 
    }

    $scope.feedback_status = function(feed) {         
        //this sends a signal to CheckyBox
        FeedbackSignal.set_status_message(feed.status)
        FeedbackSignal.set_feed_id(feed.id);

        feed.origin = Template.current_inbox_state;
        FeedbackControlService.change_status(feed);
    }

    $scope.reply_feedback = function(id) {
        console.log("reply id:" + id);
    }

    $scope.change_category = function(feedid, catid) {
        console.log("Feedback: " + feedid + " CatID: " + catid);
    }

    $scope.update_selection = function($event, id) {

        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');

        update_selected(action, id); 
    }

    $scope.change_value_status = function() {
        console.log($scope.status_select_value); 
        console.log($scope.selected); 
    }

    $scope.select_all = function($event) { 
        
        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');

        for(var i=0; i < $scope.checkboxes.length; i++) {
             
            var entity = $scope.checkboxes[i];

            if(action == "add") {
                //$(entity).prop("checked", true);     
                $(entity).click();
            } else { 
                $(entity).prop("checked", false);     
            }
           
            update_selected(action, parseInt($(entity).val(), 10)); 
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
