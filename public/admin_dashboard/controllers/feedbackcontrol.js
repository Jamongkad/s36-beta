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
        var flag_data = $.parseJSON($(".flag-action[feedid=" + me + "]").attr("data-feed"));
        var mystatus;

        if(entity.hasClass('featured')) {
            mystatus = 'feature';
        }

        if(entity.hasClass('published')) {
            mystatus = 'publish';
        }

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
            } 

            if(collect_type == 'catid') {                
                return catid;     
            } 

            if(collect_type == 'current_status') {      
                return mystatus;
            } 

            if(collect_type == 'flag_data') {
                flag_data.status = (flag_data.status == "unflag") ? "flag" : "unflag";
                return flag_data;
            }

        }    
    }

    var current_url = window.location.pathname;

    var url_params = function() { 
        var prmstr = window.location.search.substr(1);
        var prmarr = prmstr.split ("&");
        var params = {};
        
        for ( var i = 0; i < prmarr.length; i++) {
            var tmparr = prmarr[i].split("=");
                params[tmparr[0]] = tmparr[1];
        }

        return params;
    }

    $scope.selected   = [];
    $scope.uri_params = [];
    var checkboxes = $(".feed-checkbox");

    $scope.status_select_value = 'none';
    $scope.date_filter     = (!is_empty(qs) && qs['date']) ? qs['date'] : 'none';
    $scope.priority_filter = (!is_empty(qs) && qs['priority']) ? qs['priority'] : 'none';
    $scope.status_filter   = (!is_empty(qs) && qs['status']) ? qs['status'] : 'none';
    $scope.rating_filter   = (!is_empty(qs) && qs['rating']) ? qs['rating'] : 'none';
    
    $scope.feedback_status = function($event) {         

        var target = $($event.target);
        //this is the intention feed. Feed that will go into the database for updating
        var feed = $.parseJSON(target.attr('data-feed'));
        
        //get flag data feed assuming you've clicked on feedback controls
        var ulflag = target.parents('ul').children('.flag-action').attr('data-feed');

        //get flag data feed assuming you've clicked on delete button
        var delflag = target.parents('.grids').siblings('.grids').children('ul').children('.flag-action').attr('data-feed');
         
        //either way, we are all fucked
        var flag_data, flagged;
        if(ulflag) {
            flag_data = $.parseJSON(ulflag);
        } else { 
            flag_data = $.parseJSON(delflag);
        }

        flagged = (flag_data.status == "unflag") ? "flag" : "unflag";

        //below are the feed states used for undoing.
        if(current_url.match(/inbox\/all|deleted/g)) {  
            var current = {
                id: feed.id
              , catid: Template.default_category_id
              , status: feed.status
              , isflag: flagged
              , origin: Template.current_inbox_state
            }
        }

        if(current_url.match(/published/g)) {
            var current = {
                id: feed.id
              , catid: Template.default_category_id
              , status: feed.status
              , isflag: flagged
              , origin: feed.origin
            } 
        }
        
        if(current_url.match(/filed/g)) {
            var current = {
                id: feed.id
              , catid: feed.catid
              , status: feed.status
              , isflag: flagged
              , origin: Template.current_inbox_state
            } 
        } 

        var process = function() { 
            FeedbackSignal.current_state(current);
            feed.origin = Template.current_inbox_state;
            FeedbackControlService.change_status(feed, true);
        }

        if(feed.status != "remove") { 
            process();
        } else {
            if(confirm("Warning! You are about to permanently delete this feedback. There is no undo.")) {
                process();
            }
        }

    }

    $scope.update_selection = function($event, id) {
        var checkbox = $event.target;
        var action = (checkbox.checked ? 'add' : 'remove');
        update_selected(action, id); 
    }

    $scope.change_value_status = function() {
        if( $('input[type=checkbox].feed-checkbox:checked').length > 0 ) {

            var selected  = [];
            var catids    = [];
            var origin    = [];
            var flag_data = [];
            var ids  = $scope.selected;
            var mode = $scope.status_select_value;
            var feed = {};
            
            //refactor this you lazy bastard
            if(mode == "remove") {
                if(confirm("Are you sure you want to permanently remove this feedback? There is no undo.")) { 
                    for(var i=0; i < ids.length; ++i) {
                        selected.push(feedback_collect(ids[i], mode, 'feedid'));
                        catids.push(feedback_collect(ids[i], mode, 'catid')); 
                        origin.push(feedback_collect(ids[i], mode, 'current_status'));
                        flag_data.push(feedback_collect(ids[i], mode, 'flag_data'));
                    }
                } else { 
                    $('input[type=checkbox].feed-checkbox:checked, .sorter-checkbox:checked').click();
                }
            } else { 
                for(var i=0; i < ids.length; ++i) {
                    selected.push(feedback_collect(ids[i], mode, 'feedid'));
                    catids.push(feedback_collect(ids[i], mode, 'catid'));
                    origin.push(feedback_collect(ids[i], mode, 'current_status'));
                    flag_data.push(feedback_collect(ids[i], mode, 'flag_data'));
                }
            }

            var clean_selection = selected.filter(function(n) { return n });
 
            if(clean_selection.length > 0) { 

                if(current_url.match(/filed/g)) {
                    var feed = {
                        id: clean_selection
                      , status: mode
                      , isflag: flag_data
                      , catid:  catids 
                      , origin: Template.current_inbox_state
                    }
                } else if(current_url.match(/published/g)) {
                    var feed = { 
                        id: clean_selection
                      , status: mode
                      , isflag: flag_data
                      , catid: Template.default_category_id
                      , origin: origin
                    }
                } else { 
                    var feed = {
                        id: clean_selection
                      , status: mode
                      , isflag: flag_data
                      , catid: Template.default_category_id
                      , origin: Template.current_inbox_state
                    }
                }
                
                FeedbackSignal.current_state(feed);
                FeedbackControlService.change_status(feed, true);  

                $(".checky-box-container").show();  
                $(".sorter-checkbox:checked").attr('checked', false);

                if(mode == "remove") {
                    var status_message = FeedbackControlService.jsonmsg.feedback_status_change;
                    if(status_message == "success") { 
                        window.location = "/inbox/deleted/all";
         
                    }
                }

            } else {
                if(mode != "remove") {
                    alert("I am sorry. I am unable to perform this operation. Your feedback is either rated as Poor or is given Private permission by it's sender.");     
                } 
            }

            if($('.feed-checkbox').is(":checked")) { $('.feed-checkbox').prop("checked", false); }

            selected = [];
            clean_selection = [];
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
    
    $scope.process_filter = function() {
        var data = {}
        if($scope.rating_filter != 'none') {
            data.rating = $scope.rating_filter;
        }

        if($scope.status_filter != 'none') { 
            data.status = $scope.status_filter;
        }
       
        if($scope.priority_filter != 'none') {
            data.priority = $scope.priority_filter;
        }

        if($scope.date_filter != 'none') {
            data.date = $scope.date_filter;
        } 

        var result = $.param(data);
        var params = url_params();
        var page = '';
        if('page' in params) { page = '&page=' + params.page; }
        var str = '?' + result + page;
        document.location.search = str;
    }

    $scope.fast_forward = function(email, feedid) {
        FeedbackService.send_fastforward(email, feedid);
    }

    $scope.$on('expungeFeedId', function() {
        $scope.selected = [];
    })
}

function CheckyBox($scope, FeedbackSignal, FeedbackControlService) { 

    $scope.status_selection, $scope.id, $scope.data; 

    $scope.undo = function() {  
        FeedbackControlService.change_status($scope.data);
    }

    $scope.close = function() { 
        //location.reload();
        window.location = window.location.pathname;
    }

    $scope.hide = function() { 
        $(".checky-box-container").hide();
    }

    $scope.$on('checkFeedbackStatus', function() {
        console.log("Receiving...");
        var data = FeedbackSignal.get_data();
        $scope.data = data;
        $scope.status_selection = data.status;  
    });
}
