//abstract base class
function InboxStateObject() {
    this.baseUrl = $('select[name="delete_selection"]').attr('base-url');             
}

InboxStateObject.prototype.undo = function() {

    var me = this;
    $('a.undo').live('click', function(e) {

        var feedid    = $(this).attr('href');
        var href      = $(this).attr('hrefaction'); 
        var undo_type = $(this).attr('undo-type');
        var undo_mode = $('.inbox-state').val();

        //set current_catid variable for undo function
        var current_catid = $(me.elem).siblings('div.base-popup').children('.category-picker').attr('id');
        var sec       = 350;

        $("#" + me.feeds.feedid).fadeIn(sec);
        $(this).parents("."+undo_type).fadeOut(sec, function() { $(this).remove(); }); 
        $.ajax({ type: "POST", url: href, data: {"mode": undo_mode, "feed_ids": [me.feeds], "cat_id": current_catid, "catstate": true} });  
        e.preventDefault(); 
    });
}

InboxStateObject.prototype.process = function() {

    var me = this; 

    $(this.elem).parents('.feedback').fadeOut(350, function() {
        var undo       = " <a class='undo' hrefaction='" + me.href + "' href='#' undo-type='" + me.identifier + "'>undo</a>";
        var notify_msg = me.message + undo;
        var notify     = $('<div/>').addClass(me.identifier).html(notify_msg);
        var checky = $('.checky-bar');
        checky.html(notify).show();

        if(me.state == 0) {   
            $.ajax({ type: "POST", url: me.href, data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid, "catstate": me.catstate }, success: function() 
                {
                    checky.html(notify).show();
                } 
            });
        } else {  
            //if state is 1 then we're going back to the inbox
            $.ajax({ type: "POST", url: me.href, data: {"mode": "inbox" ,"feed_ids": [me.feeds], "cat_id": me.catid }, success: function() 
                { 
                    checky.html("<div class='" + me.identifier + "'>Feedback has been sent to the " + "<a href='" + me.baseUrl + "inbox/all'>Inbox</a> " + undo + "</div>")
                    .show();
                } 
            });
        }

    });
}

//child implementation classes
function CheckStateObject(elem) {
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
CheckStateObject.prototype = new InboxStateObject();

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

    if(location.pathname.match(/filed/)) {
        $.ajax({ type: "POST", url: me.href, data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid, "catstate": me.catstate }, success: function() {
            if(me.catstate == "default") {
                $(me.elem).parents('.feedback').fadeOut(350);
            }
        }});
    } else {  
        $(this.elem).parents('.feedback').fadeOut(350, function() {
            var undo       = " <a class='undo' hrefaction='" + me.href + "' href='#' undo-type='" + me.identifier + "'>undo</a>";
            var notify_msg = me.message + undo;
            var notify     = $('<div/>').addClass(me.identifier).html(notify_msg);
            var checky = $('.checky-bar');

            if(me.state == 0) {   
                $.ajax({ type: "POST", url: me.href, data: {"mode": me.mode ,"feed_ids": [me.feeds], "cat_id": me.catid, "catstate": me.catstate }, success: function() 
                    {
                        checky.html(notify).show();
                    } 
                });
            } else {  
                //if state is 1 then we're going back to the inbox
                $.ajax({ type: "POST", url: me.href, data: {"mode": "inbox" ,"feed_ids": [me.feeds], "cat_id": me.catid }, success: function() 
                    { 
                        checky.html("<div class='" + me.identifier + "'>Feedback has been sent to the " + "<a href='" + me.baseUrl + "inbox/all'>Inbox</a> " + undo + "</div>")
                        .show();
                    } 
                });
            }
        });
    }
}

//Factory
function InboxStatusChange(opts)  {
    this.inbox_controls = opts;    
}

InboxStatusChange.prototype.initialize = function() {
    var me = this;
    $(me.inbox_controls).bind("click", function() {  
        var identifier = $(this).attr('class');         

        if(identifier == 'check') {
            var check = new CheckStateObject($(this));
            check.process();
            check.undo();
        }

        if(identifier == 'feature') { 
            var feature = new FeatureStateObject($(this));
            feature.process();
            feature.undo();
        }

        if(identifier == 'remove') { 
            var remove = new RemoveStateObject($(this));
            remove.process();
            remove.undo();
        }

        if(identifier == 'cat-picks') {
            var catpick = new CatPickObject($(this));
            catpick.process();
            catpick.undo();
        }
    })   
}
