//abstract base class
function InboxStateObject(elem) {
    this.baseUrl = $("input[name='baseUrl']").val();
    this.elem = elem;
    this.currentUrl = window.location.pathname;
    this.message = "Feedback is broadcasted and moved to " + "<a href='" +this.baseUrl+ "inbox/published/all'>Published Folder</a>";
    this.feedid = $(elem).attr('feedid');      
    this.href   = $(elem).attr('hrefaction'); 
    this.catid  = $(elem).attr('catid');
    this.catstate = $(elem).attr('cat-state');
    this.state  = $(elem).attr('state');
    this.feeds = {feedid: this.feedid};
    this.identifier = $(elem).attr('class');
}

InboxStateObject.prototype.undo = function() {
    var me = this;
    $("a.undo").bind("click", function(e) {
        var undo_type = $(this).attr('undo-type');
        var undo_mode = $('.inbox-state').val();
        var current_catid = me.elem.attr('catid');
        var feed_elem = $("#" + me.feeds.feedid);
        var state_data = {"mode": undo_mode, "feed_ids": [me.feeds], "cat_id": current_catid, "href": me.href}
        var sec = 350;

        feed_elem.parents('.feedback-group').show();
        feed_elem.fadeIn(sec);
        
        $(this).parents("."+undo_type).fadeOut(sec, function() { $(this).remove(); });    
        change_state(state_data); 
        e.preventDefault();  
    });
}

InboxStateObject.prototype.process = function() {

    var me = this; 
    var is_single = $(me).attr('feedid');
    var mode = (me.state == 1) ? "inbox" : me.mode;
    var state_data = { "mode": mode, "feed_ids": [me.feeds], "cat_id": me.catid, "href": me.href }
    var state_view_data;
     
    if(is_single) { 
        if(me.currentUrl.match(/published|contacts/g)) {

            //HTML view transforms
            if(mode == 'feature') { featured_feed_view_change(me); }
            if(mode == 'publish') { published_feed_view_change(me); }
            
            //these modes will fadeout feeds in the publish and contact modules
            if(mode == 'inbox' || mode == 'delete') {

                feed_fadeout(me);

                if(mode == 'inbox') {
                    me.message = "Feedback returned to inbox";     
                } 
                checky_bar_message(me);
            }

            change_state(state_data);

        } else {
            feed_fadeout(me);
            checky_bar_message(me);
            change_state(state_data);
        }
    }
     
    $(document).delegate('a.close-checky', 'click', function(e) { 
        $(this).parents('.check').remove();
        e.preventDefault(); 
    });
}

//child implementation classes
function PublishStateObject(elem) {
    InboxStateObject.apply(this, arguments);
    this.message = "Feedback has been published to your page."; 
    this.mode    = "publish"; 
}
PublishStateObject.prototype = new InboxStateObject();

function FeatureStateObject(elem) { 
    InboxStateObject.apply(this, arguments);
    this.message = "Feedback has been featured to your page.";
    this.mode    = "feature"; 
}
FeatureStateObject.prototype = new InboxStateObject();

function RemoveStateObject(elem) { 
    InboxStateObject.apply(this, arguments);
    this.message = "Feedback has been " + "<a href='" +this.baseUrl+ "inbox/deleted/all'>deleted</a>"; 
    this.mode    = "delete";
}
RemoveStateObject.prototype = new InboxStateObject();

function CatPickObject(elem) {
    InboxStateObject.apply(this, arguments);
    this.message = "Feedback has been sent to " + "<a href='" +this.baseUrl+ "inbox/filed/all'>Filed Feedback</a>";       
    this.mode    = "fileas";
    $(elem).parents('div.category-picker-holder').hide();
}

CatPickObject.prototype = new InboxStateObject();
CatPickObject.prototype.process = function() {

    var me = this;
    var is_single = $(me).attr('feedid');
    var mode = me.mode;
    var state_data = { "mode": mode, "feed_ids": [me.feeds], "cat_id": me.catid, "href": me.href }
    //console.log(state_data);
    if(is_single) { 
        if(me.currentUrl.match(/filed|modifyfeedback/g)) {
            change_state(state_data);
        } else {  
            $(me.elem).parents('.feedback').fadeOut(350);
            checky_bar_message(me);
            change_state(state_data); 
        }
    }

    $(document).delegate('a.close-checky', 'click', function(e) { 
        $(this).parents('.check').remove();
        e.preventDefault(); 
    })
}

//Factory
function InboxStatusChange(opts)  {
    this.inbox_controls = opts;    
}

InboxStatusChange.prototype.initialize = function() {
    var me = this;
    $(document).delegate(me.inbox_controls, 'click', function(e) {
        var identifier = $(this).attr('class');         
        var us = $(this);

        $.ajax({url: "/feedback/bust_hostfeed_data"});

        if(identifier == 'check') {
            var check = new PublishStateObject(us);
            check.process();
            check.undo();
        }

        if(identifier == 'feature') { 
            var feature = new FeatureStateObject(us);
            feature.process();
            feature.undo();
        }

        if(identifier == 'remove' || identifier == 'popup-delete') { 
            var remove = new RemoveStateObject(us);
            remove.process();
            remove.undo();
        }
    })
}

function checky_bar_message(opts, undo_msg) { 

    var undo_msg = typeof undo_msg !== 'undefined' ? undo_msg : false;

    var check_message = $('.checky-bar');
    var undo = "  <a class='undo' hrefaction='" + opts.href + "' href='#' undo-type='" + opts.identifier + "'>Undo</a>";
    var close_checky = "  <a class='close-checky' href='#'>Close</a>";

    var notify_msg = opts.message + undo + close_checky; 

    if(undo_msg) {
        var notify_msg = opts.message;        
    }

    var notify  = $('<div/>').addClass(opts.identifier).css({'text-align': 'center'}).html(notify_msg);
    check_message.html(notify).show();
}

function change_view(opts) { 
    $(opts.elem).parents('.feedback').css({'background-color': opts.color});
    $(opts.elem).css({'background-position': opts.position});
    $(opts.elem).attr('state', 1);
    $(opts.elem).siblings(opts.sibling).removeAttr('style');
    $(opts.elem).siblings(opts.sibling).attr('state', 0);
}

function feed_fadeout(opts) { 
    $(opts.elem).parents('.feedback').fadeOut(350, function() { feedback_group_display(opts.feeds.feedid); });
}

function feedback_group_display(feedid) { 
    var feed_group = $("#" + feedid).parents('.feedback-group');
    var child_counts = feed_group.children('.feedback:visible').length;

    if(child_counts == 0) { 
        feed_group.hide(); 
        $('#maskDisabler').fadeIn();
        setTimeout(function() { window.location.reload(1); }, 2000);
    } 
}

function featured_feed_view_change(me) { 
    state_view_data = {
        'elem': me.elem
      , 'color': '#FFFFE0'
      , 'position': '-60px -34px'
      , 'sibling': '.check'
    };
    checky_bar_message(me, true);
    change_view(state_view_data); 
}

function published_feed_view_change(me) {
    state_view_data = {
        'elem': me.elem
      , 'color': '#FFFFFF'
      , 'position': '0px -34px'
      , 'sibling': '.feature'
    };
    checky_bar_message(me, true);
    change_view(state_view_data);  
}

//server side processing
function change_state(state_data) { 
    newfeedback_process(state_data.feed_ids);

    $.ajax({ 
        type: "POST"
      , url: state_data.href
      , data: state_data
      , success: function() {
            var myStatus = new Status();
            myStatus.notify("Processing...", 1000);
        } 
    });

}
