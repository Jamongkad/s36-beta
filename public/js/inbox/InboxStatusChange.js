//abstract base class
function InboxStateObject() {
    this.baseUrl = $("input[name='baseUrl']").val();
    this.currentUrl = window.location.pathname;
}

InboxStateObject.prototype.undo = function() {

    var me = this;
    $(document).delegate("a.undo", "click", function(e) {
        var feedid    = $(this).attr('href');
        var href      = $(this).attr('hrefaction'); 
        var undo_type = $(this).attr('undo-type');
        var undo_mode = $('.inbox-state').val();

        var current_catid = me.elem.attr('catid');
        var sec       = 350;

        $("#" + me.feeds.feedid).fadeIn(sec);
        $(this).parents("."+undo_type).fadeOut(sec, function() { $(this).remove(); }); 
        $.ajax({  type: "POST"
                , url: href
                , data: {"mode": undo_mode, "feed_ids": [me.feeds], "cat_id": current_catid, "catstate": true} 
                , success: function () {
                    var myStatus = new Status();
                    myStatus.notify("Processing...", 1000); 
                  }
               });  
        e.preventDefault(); 
    });     
}

InboxStateObject.prototype.process = function() {

    var me = this; 
    var is_single = $(me).attr('feedid');
    console.log(is_single);
    console.log(me.mode);
    console.log(me.currentUrl);
    var in_published_tab = me.currentUrl.match(/published/g);
    if(in_published_tab) {
        console.log("In Published tab");    
    } else {
        console.log("Not in Published tab");
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

                $.ajax({ type: "POST", url: me.href, data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid, "catstate": me.catstate }
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

                $.ajax({ type: "POST", url: me.href, data: {"mode": "inbox" ,"feed_ids": [me.feeds], "cat_id": me.catid }
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
    
    $(document).delegate('a.close-checky', 'click', function(e) { 
        $(this).parents('.check').remove();
        e.preventDefault(); 
    })

}

//child implementation classes
function PublishStateObject(elem) {
    InboxStateObject.apply(this, arguments);
    this.elem = elem; 
    this.message = "Feedback has been published and moved to " + "<a href='" +this.baseUrl+ "inbox/published/all'>Published Folder</a>";
    this.mode    = "publish"; 
    this.feedid = $(elem).attr('feedid');      
    this.href   = $(elem).attr('hrefaction'); 
    this.catid  = $(elem).attr('catid');
    this.catstate = $(elem).attr('cat-state');
    this.state  = $(elem).attr('state');
    this.feeds = {feedid: this.feedid};
    this.identifier = $(elem).attr('class');
}
PublishStateObject.prototype = new InboxStateObject();

function FeatureStateObject(elem) { 
    InboxStateObject.apply(this, arguments);
    this.elem = elem;
    this.message = "Feedback has been published and moved to " + "<a href='" +this.baseUrl+ "inbox/featured/all'>Featured Folder</a>"; 
    this.mode    = "feature"; 
    this.feedid = $(elem).attr('feedid');      
    this.href   = $(elem).attr('hrefaction'); 
    this.catid  = $(elem).attr('catid');
    this.catstate = $(elem).attr('cat-state');
    this.state  = $(elem).attr('state');
    this.feeds = {feedid: this.feedid};
    this.identifier = $(elem).attr('class');
}
FeatureStateObject.prototype = new InboxStateObject();

function RemoveStateObject(elem) { 
    InboxStateObject.apply(this, arguments);
    this.elem = elem;
    this.message = "Feedback has been " + "<a href='" +this.baseUrl+ "inbox/deleted'>deleted</a>"; 
    this.mode    = "delete";
    this.feedid = $(elem).attr('feedid');      
    this.href   = $(elem).attr('hrefaction'); 
    this.catid  = $(elem).attr('catid');
    this.catstate = $(elem).attr('cat-state');
    this.state  = $(elem).attr('state');
    this.feeds = {feedid: this.feedid};
    this.identifier = $(elem).attr('class');
}
RemoveStateObject.prototype = new InboxStateObject();

function CatPickObject(elem) {
    InboxStateObject.apply(this, arguments);
    this.elem = elem;
    this.catstate = $(elem).attr('cat-state');
    if(this.catstate == 'default') {
        this.message = "Feedback has been sent to " + "<a href='" +this.baseUrl+ "inbox/all'>Inbox</a>";       
    } else { 
        this.message = "Feedback has been sent to " + "<a href='" +this.baseUrl+ "inbox/filed/all'>Filed Feedback</a>";       
    } 
    this.mode    = "fileas";
    $(elem).parents('div.category-picker-holder').hide();
    this.feedid = $(elem).attr('feedid');      
    this.href   = $(elem).attr('hrefaction'); 
    this.catid  = $(elem).attr('catid');
    this.catstate = $(elem).attr('cat-state');
    this.state  = $(elem).attr('state');
    this.feeds = {feedid: this.feedid};
    this.identifier = $(elem).attr('class');
}

CatPickObject.prototype = new InboxStateObject();
CatPickObject.prototype.process = function() {
    var me = this;
    if(location.pathname.match(/filed|modifyfeedback/)) {
        $.ajax({ type: "POST", url: me.href, data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid, "catstate": me.catstate }, success: function() {
            if(me.catstate == "default") {
                $(me.elem).parents('.feedback').fadeOut(350);
            }
            var myStatus = new Status();
            myStatus.notify("Processing...", 1000);
        }});
    } else {  
        $(this.elem).parents('.feedback').fadeOut(350, function() {
            var undo       = " <a class='undo' hrefaction='" + me.href + "' href='#' undo-type='" + me.identifier + "'>Undo</a>";
            var close_checky = "  <a class='close-checky' href='#'>Close</a>";
            var notify_msg = me.message + undo + close_checky;
            var notify     = $('<div/>').addClass(me.identifier).html(notify_msg);
            var checky = $('.checky-bar');

            if(me.state == 0) {   
                $.ajax({ type: "POST", url: me.href, data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid, "catstate": me.catstate }, success: function() 
                    {

                        var myStatus = new Status();
                        myStatus.notify("Processing...", 1000);
                        checky.html(notify).show();
                    } 
                });
            } else {  
                //if state is 1 then we're going back to the inbox
                $.ajax({ type: "POST", url: me.href, data: {"mode": "inbox" ,"feed_ids": [me.feeds], "cat_id": me.catid }, success: function() 
                    { 

                        var myStatus = new Status();
                        myStatus.notify("Processing...", 1000);
                        checky.html("<div class='" + me.identifier + "'>Feedback has been sent to the " + "<a href='" + me.baseUrl + "inbox/all'>Inbox</a> " + undo + close_checky +"</div>")
                        .show();
                    } 
                });
            }
        });

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
