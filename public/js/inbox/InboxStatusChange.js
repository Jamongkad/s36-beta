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
    $(document).delegate("a.undo", "click", function(e) {
        var feedid    = $(this).attr('href');
        var href      = $(this).attr('hrefaction'); 
        var undo_type = $(this).attr('undo-type');
        var undo_mode = $('.inbox-state').val();

        var current_catid = me.elem.attr('catid');
        var state_data = {"mode": undo_mode, "feed_ids": [me.feeds], "cat_id": current_catid}
        var sec = 350;

        $("#" + me.feeds.feedid).fadeIn(sec);
        $(this).parents("."+undo_type).fadeOut(sec, function() { $(this).remove(); }); 
       
        console.log(state_data);
        /*
        $.ajax({  type: "POST"
                , url: href
                , data: {"mode": undo_mode, "feed_ids": [me.feeds], "cat_id": current_catid, "catstate": true} 
                , success: function () {
                    var myStatus = new Status();
                    myStatus.notify("Processing...", 1000); 
                  }
               });  
        */
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
            console.log(state_data);
            //HTML view transforms
            if(mode == 'feature') {
                state_view_data = {
                    'elem': me.elem
                  , 'color': '#FFFFE0'
                  , 'position': '-60px -34px'
                  , 'sibling': '.check'
                };

                change_view(state_view_data); 
            }

            if(mode == 'publish') {
                state_view_data = {
                    'elem': me.elem
                  , 'color': '#FFFFFF'
                  , 'position': '0px -34px'
                  , 'sibling': '.feature'
                };

                change_view(state_view_data); 
            }
            
            //these modes will fadeout feeds in the publish and contact modules
            if(mode == 'inbox' || mode == 'delete') {
                $(me.elem).parents('.feedback').fadeOut(350);
                if(mode == 'inbox') {
                    me.message = "feedback returned to inbox";     
                } 
                checky_bar_message(me);
            }
            //change_state(state_data);
        } else {
            console.log(state_data);
            $(me.elem).parents('.feedback').fadeOut(350);
            checky_bar_message(me);
            //change_state(state_data);
        }
    }
     
    $(document).delegate('a.close-checky', 'click', function(e) { 
        $(this).parents('.check').remove();
        e.preventDefault(); 
    })

}

//child implementation classes
function PublishStateObject(elem) {
    InboxStateObject.apply(this, arguments);
    this.mode    = "publish"; 
}
PublishStateObject.prototype = new InboxStateObject();

function FeatureStateObject(elem) { 
    InboxStateObject.apply(this, arguments);
    this.mode    = "feature"; 
}
FeatureStateObject.prototype = new InboxStateObject();

function RemoveStateObject(elem) { 
    InboxStateObject.apply(this, arguments);
    this.message = "Feedback has been " + "<a href='" +this.baseUrl+ "inbox/deleted'>deleted</a>"; 
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

    if(is_single) { 
        if(me.currentUrl.match(/filed|modifyfeedback/)) {
            //console.log(state_data);
            change_state(state_data);
        } else { 
            //console.log(state_data);
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

function checky_bar_message(opts) { 
    var check_message = $('.checky-bar');

    var undo = "  <a class='undo' hrefaction='" + opts.href + "' href='#' undo-type='" + opts.identifier + "'>Undo</a>";
    var close_checky = "  <a class='close-checky' href='#'>Close</a>";
    var notify_msg = opts.message + undo + close_checky; 

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

function change_state(state_data) { 
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

//TODO: if in Published Folder do not animate else animate in Inbox Folder only.
    /* 
    if(is_single) { 
        $(me.elem).parents('.feedback').fadeOut(350, function() {
            var undo       = "  <a class='undo' hrefaction='" + me.href + "' href='#' undo-type='" + me.identifier + "'>Undo</a>";
            var close_checky = "  <a class='close-checky' href='#'>Close</a>";
            var notify_msg = me.message + undo + close_checky; 
            var notify     = $('<div/>').addClass(me.identifier).html(notify_msg);
            var checky = $('.checky-bar');

            if(me.state == 0) {   
                console.log(me.href);
                console.log(me.state);

                $.ajax({ type: "POST"
                       , url: me.href
                       , data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid }
                       , success: function() {
                             checky.html(notify).show();
                             var myStatus = new Status();
                             myStatus.notify("Processing...", 1000);
                         } 
                });

            } else {  
                //if state is 1 then we're going back to the inbox 
                console.log(me.href);
                console.log(me.state);

                $.ajax({ type: "POST"
                      , url: me.href
                      , data: {"mode": "inbox" ,"feed_ids": [me.feeds], "cat_id": me.catid }
                      , success: function() { 
                            checky.html("<div class='" + me.identifier + "'>Feedback has been sent to the " + "<a href='" + me.baseUrl + "inbox/all'>Inbox</a> " + undo + close_checky + "</div>")
                            .show();

                            var myStatus = new Status();
                            myStatus.notify("Processing...", 1000);
                        } 
                });

            }

        });
    }
    */

    /*
    if(me.currentUrl.match(/filed|modifyfeedback/)) {
   
        $.ajax({ type: "POST"
               , url: me.href
               , data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid, "catstate": me.catstate }
               , success: function() {
                     if(me.catstate == "default") {
                         $(me.elem).parents('.feedback').fadeOut(350);
                     }
                     var myStatus = new Status();
                     myStatus.notify("Processing...", 1000);
                 }
        });
  
    } else {  
        $(this.elem).parents('.feedback').fadeOut(350, function() {
            var undo       = " <a class='undo' hrefaction='" + me.href + "' href='#' undo-type='" + me.identifier + "'>Undo</a>";
            var close_checky = "  <a class='close-checky' href='#'>Close</a>";
            var notify_msg = me.message + undo + close_checky;
            var notify     = $('<div/>').addClass(me.identifier).html(notify_msg);
            var checky = $('.checky-bar');

            if(me.state == 0) {   
 
                $.ajax({ type: "POST"
                       , url: me.href
                       , data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid, "catstate": me.catstate }
                       , success: function() {
                            var myStatus = new Status();
                            myStatus.notify("Processing...", 1000);
                            checky.html(notify).show();
                         } 
                });

            } else {  
                //if state is 1 then we're going back to the inbox

                $.ajax({ type: "POST"
                       , url: me.href
                       , data: {"mode": "inbox" ,"feed_ids": [me.feeds], "cat_id": me.catid }
                       , success: function() { 
                            var myStatus = new Status();
                            myStatus.notify("Processing...", 1000);
                            checky.html("<div class='" + me.identifier + "'>Feedback has been sent to the " + "<a href='" + me.baseUrl + "inbox/all'>Inbox</a> " + undo + close_checky +"</div>").show();
                        } 
                });

            }
        });
    }
    */
