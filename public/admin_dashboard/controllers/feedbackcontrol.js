function FeedbackControl($scope, FeedbackControlService, FeedbackSignal, Template, FeedbackService) { 

    var qs = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i) {
            var p=a[i].split('=');
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'));

    var is_empty = function(obj) {
        return Object.keys(obj).length === 0;
    }

    var update_selected = function(action, id) {
        if (action == 'add' && $scope.selected.indexOf(id) == -1) {
            $scope.selected.push(id);     
        }
       
        if (action == 'remove' && $scope.selected.indexOf(id) != -1) {
            $scope.selected.splice($scope.selected.indexOf(id), 1);     
        } 
    }

    var feedback_collect = function(n, mode, collect_type) { 
        var me = n;

        var entity = $(".dashboard-feedback[feedback=" + me + "]");
        var entity_parent = entity.parents('.feedback-group');
        var score = entity.attr('score');
        var permission = entity.attr('permission');
        var catid = entity.attr('catid');

        if(
               (score >= 3 && permission == 1)
           || ((score >= 3 && permission == 0) && (mode == 'delete' || mode == 'restore' || mode == 'remove'))
           || ((score == 1 || score == 2) && (mode == 'delete' || mode == 'restore' || mode == 'remove'))  
          )  {
            entity.hide();
            var child_count = entity_parent.children('.dashboard-feedback:visible');

            if(child_count.length == 0) {  
                entity_parent.hide(); 
            }           
            
            if(collect_type == 'feedid') {
                return me;     
            } else {                
                return catid;     
            } 
        }    
    }

    var current_url = window.location.pathname;

    var insert_param = function(key, value) {

        var key = escape(key); value = escape(value);
        var kvp = document.location.search.substr(1).split('&');
        if (kvp == '') {
            document.location.search = '?' + key + '=' + value;
        } else { 
            var i=kvp.length; 
            var x; 
            while(i--) {
                x = kvp[i].split('=');

                if (x[0]==key) {
                    x[1] = value;
                    kvp[i] = x.join('=');
                    break;
                }
            }

            if (i<0) {
                kvp[kvp.length] = [key,value].join('=');
            }

            //this will reload the page, it's likely better to store this until finished
            document.location.search = kvp.join('&'); 
        }
    }

    $scope.selected = [];
    var checkboxes = $(".feed-checkbox");

    $scope.status_select_value = 'none';
    $scope.date_filter     = (!is_empty(qs) && qs['date']) ? qs['date'] : 'none';
    $scope.priority_filter = (!is_empty(qs) && qs['priority']) ? qs['priority'] : 'none';
    $scope.status_filter   = (!is_empty(qs) && qs['status']) ? qs['status'] : 'none';
    $scope.rating_filter   = (!is_empty(qs) && qs['rating']) ? qs['rating'] : 'none';
    
    $scope.feedback_status = function($event) {         

        var target = $($event.target);
        var feed = $.parseJSON(target.attr('data-feed'));
        
        if(current_url.match(/filed/g)) {
            var current = {
                id: feed.id
              , catid: feed.catid
              , status: feed.status
              , origin: Template.current_inbox_state
            } 
        } else { 
            var current = {
                id: feed.id
              , catid: Template.default_category_id
              , status: feed.status
              , origin: Template.current_inbox_state
            }
        }

        if(feed.status != "remove") { 
            FeedbackSignal.current_state(current);
            feed.origin = Template.current_inbox_state;
            FeedbackControlService.change_status(feed, true);
        }else {
            if(confirm("Warning! You are about to permanently delete this feedback. There is no undo.")) {
                FeedbackSignal.current_state(current);
                feed.origin = Template.current_inbox_state;
                FeedbackControlService.change_status(feed, true);
            }
        }
    }

    $scope.flag_feedback = function($event) {
        var flag = $($event.target);
        var feed = $.parseJSON(flag.attr('data-feed')); 

        var return_policy = flag.attr('return-policy') == true;

        var modfeed = {
            id: feed.id      
          , catid: (current_url.match(/filed/g)) ? feed.catid : Template.default_category_id
          , status: (return_policy == true) ? feed.status : 'unflag'
          , origin: Template.current_inbox_state 
        }

        FeedbackControlService.flag_feedback(modfeed);
    }

    $scope.update_selection = function($event, id) {
        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');
        update_selected(action, id); 
    }

    $scope.change_value_status = function() {
        if( $('input[type=checkbox].feed-checkbox:checked').length > 0 ) {

            var selected = [];
            var catids = [];
            var ids = $scope.selected;
            var mode = $scope.status_select_value;
            var feed = {};

            if(mode == "remove") {
                if(confirm("Are you sure you want to permanently remove this feedback? There is no undo.")) { 
                    for(var i=0; i < ids.length; ++i) {
                        selected.push(feedback_collect(ids[i], mode, 'feedid'));
                        catids.push(feedback_collect(ids[i], mode, 'catid'));
                    }
                } else { 
                    $('input[type=checkbox].feed-checkbox:checked, .sorter-checkbox:checked').click();
                }
            } else { 
                for(var i=0; i < ids.length; ++i) {
                    selected.push(feedback_collect(ids[i], mode, 'feedid'));
                    catids.push(feedback_collect(ids[i], mode, 'catid'));
                }
            }

            if(selected.length > 0) { 
                if(current_url.match(/filed/g)) {
                    var feed = {
                        id: selected
                      , status: $scope.status_select_value
                      , catid:  catids 
                      , origin: Template.current_inbox_state
                    }
                } else { 
                    var feed = {
                        id: selected
                      , status: $scope.status_select_value
                      , catid: Template.default_category_id
                      , origin: Template.current_inbox_state
                    }
                }

                if(mode == "remove") { 
                    FeedbackSignal.current_state(feed);
                    FeedbackControlService.change_status(feed, true);  
                } else { 
                    FeedbackSignal.current_state(feed);
                    FeedbackControlService.change_status(feed, true);  
                }

                $(".checky-box-container").show();  

            } else {
                if(mode != "remove") {
                    alert("Action is not allowed!");     
                } 
            }

            selected = [];
            $scope.selected = []; 
            $scope.status_select_value = 'none';
        
        }
    }

    $scope.select_all = function($event) { 
        
        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');

        for(var i=0; i < checkboxes.length; i++) {
             
            var entity = $(checkboxes[i]);
            var myparent = entity.parents('.dashboard-feedback');

            //if action is add then click on checkboxes if not click again to deselect
            if(action == "add") {
                if(!entity.is(":checked")) {
                    entity.click();     
                } 
            } else { 
                entity.click();     
            }

            update_selected(action, parseInt(entity.val(), 10));      
        }
    }

    $scope.filter = function(filter_type) {
        if(filter_type == 'date') {
            if($scope.date_filter == 'none') {
                window.location = window.location.pathname;
            } else { 
                insert_param('date', $scope.date_filter);     
            }
        }
        
        if(filter_type == 'priority') {
            if($scope.priority_filter == 'none') {
                window.location = window.location.pathname;
            } else { 
                insert_param('priority', $scope.priority_filter);     
            }
        }

        if(filter_type == 'status') {
            if($scope.status_filter == 'none') {
                window.location = window.location.pathname;
            } else { 
                insert_param('status', $scope.status_filter);     
            }
        }

        if(filter_type == 'rating') {
            if($scope.rating_filter == 'none') {
                window.location = window.location.pathname;
            } else { 
                insert_param('rating', $scope.rating_filter);     
            }
        }
    }

    $scope.fast_forward = function(email, feedid) {
        FeedbackService.send_fastforward(email, feedid);
    }

    $scope.$on('expungeFeedId', function() {
        FeedbackSignal.data.id = [];
        $scope.selected = [];
    })
}

function CheckyBox($scope, FeedbackSignal, FeedbackControlService) { 

    $scope.status_selection; 
    var checkboxes = $(".feed-checkbox:not(:hidden)");

    $scope.undo = function() { 
        FeedbackControlService.change_status(FeedbackSignal.data, false);
    }

    $scope.close = function() { 
        location.reload();
    }

    $scope.$on('checkFeedbackStatus', function() {
        $scope.status_selection = FeedbackSignal.data.status;
        $scope.id = FeedbackSignal.data.id;
    });
}
