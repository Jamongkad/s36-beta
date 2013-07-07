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
            var str = '?' + key + '=' + value;
            document.location.search = str;
        } else { 
            var i=kvp.length; 
            var x; 
            $scope.uri_params = kvp;
            if(value != "none") {
                console.log("add");
                $scope.uri_params.push(key + '=' + value);
            } else { 
                console.log("remove");
                $scope.uri_params.splice($scope.uri_params.indexOf(key + "=" + value), 1);     
            }

            console.log($scope.uri_params);
            /*             
            while(i--) {
                x = kvp[i].split('=');
 
                if (x[0]==key) {
                    x[1] = value;
                    kvp[i] = x.join('=');
                    break;
                }   
            } 

            if (i<0) {
                console.log("DAH");
                kvp[kvp.length] = [key,value].join('=');
            }
            console.log(kvp);
            var str = kvp.join('&');
            console.log(str);
            //this will reload the page, it's likely better to store this until finished
            //document.location.search = str;
            */
        }
    }

    $scope.selected = [];
    $scope.uri_params = [];
    var checkboxes = $(".feed-checkbox");

    $scope.status_select_value = 'none';
    $scope.date_filter     = (!is_empty(qs) && qs['date']) ? qs['date'] : 'none';
    $scope.priority_filter = (!is_empty(qs) && qs['priority']) ? qs['priority'] : 'none';
    $scope.status_filter   = (!is_empty(qs) && qs['status']) ? qs['status'] : 'none';
    $scope.rating_filter   = (!is_empty(qs) && qs['rating']) ? qs['rating'] : 'none';
    
    $scope.feedback_status = function($event) {         
        var target = $($event.target);
        var feed = $.parseJSON(target.attr('data-feed'));

        if(current_url.match(/inbox\/all|deleted/g)) {  
            var current = {
                id: feed.id
              , catid: Template.default_category_id
              , status: feed.status
              , origin: Template.current_inbox_state
            }
        }

        if(current_url.match(/published/g)) {
            var current = {
                id: feed.id
              , catid: Template.default_category_id
              , status: feed.status
              , origin: feed.origin
            } 
        }
        
        if(current_url.match(/filed/g)) {
            var current = {
                id: feed.id
              , catid: feed.catid
              , status: feed.status
              , origin: Template.current_inbox_state
            } 
            console.log(current);
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
    
    /*
    $scope.filter = function(filter_type) {
        if(filter_type == 'date') {
            insert_param('date', $scope.date_filter);     
        }
        
        if(filter_type == 'priority') {
            insert_param('priority', $scope.priority_filter);     
        }

        if(filter_type == 'status') {
            insert_param('status', $scope.status_filter);     
        }

        if(filter_type == 'rating') {
            insert_param('rating', $scope.rating_filter);      
        }
    }
    */

    $scope.process_filter = function() {

        var data = {}
        if($scope.rating_filter != 'none') {
            //console.log($scope.rating_filter)  
            data.rating = $scope.rating_filter;
        }

        if($scope.status_filter != 'none') { 
            //console.log($scope.status_filter) 
            data.status_filter = $scope.status_filter;
        }
       
        if($scope.priority_filter != 'none') {
            //console.log($scope.priority_filter) 
            data.priority = $scope.priority_filter;
        }

        if($scope.date_filter != 'none') {
            //console.log($scope.date_filter)      
            data.status_date = $scope.date_filter;
        } 

        console.log(data);
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
    $scope.id; 
    $scope.data; 

    $scope.undo = function() { 
        FeedbackControlService.change_status($scope.data);
    }

    $scope.close = function() { 
        location.reload();
    }

    $scope.$on('checkFeedbackStatus', function() {
        $scope.status_selection = FeedbackSignal.data.status;
        $scope.id = FeedbackSignal.data.id;
        $scope.data = FeedbackSignal.data;
    });
}
