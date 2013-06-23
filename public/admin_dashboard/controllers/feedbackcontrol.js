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
        var current = {
            id: feed.id
          , catid: Template.default_category_id
          , status: feed.status
          , origin: Template.current_inbox_state
        }

        FeedbackSignal.current_state(current);

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
        if( $('input[type=checkbox].feed-checkbox:checked').length > 0 ) {

            console.log("changed");
            for(var i=0; i < $scope.selected.length; i++) {

                var entity = $(".dashboard-feedback[feedback=" + $scope.selected[i] + "]");
                var entity_parent = $(entity).parents('.feedback-group');
                
                entity.hide();

                var child_count = entity_parent.children('.dashboard-feedback:visible');

                if(child_count.length == 0) {  
                    entity_parent.hide(); 
                }      

            }

            var feed = {
                id: $scope.selected     
              , status: $scope.status_select_value
              , catid: Template.default_category_id
              , origin: Template.current_inbox_state
            }

            FeedbackSignal.current_state(feed);
            FeedbackControlService.change_status(feed);
            $scope.selected = [];

            $(".checky-box-container").show();  
        }
    }

    $scope.select_all = function($event) { 
        
        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');

        for(var i=0; i < $scope.checkboxes.length; i++) {
             
            var entity = $scope.checkboxes[i];
            //if action is add then click on checkboxes if not click again to deselect
            if(action == "add") {
                if(!$(entity).is(":checked")) {
                    $(entity).click();     
                } 
            } else { 
                $(entity).click();     
            }
           
            update_selected(action, parseInt($(entity).val(), 10)); 
        }
    }

    $scope.$on('expungeFeedId', function() {
        FeedbackSignal.data.id = [];
        $scope.selected = [];
    })
}

function CheckyBox($scope, FeedbackSignal, FeedbackControlService) { 

    $scope.status_selection;

    $scope.undo = function() { 
        FeedbackControlService.change_status(FeedbackSignal.data);
    }

    $scope.$on('checkFeedbackStatus', function() {
        $scope.status_selection = FeedbackSignal.data.status;
    });
}
