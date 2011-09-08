jQuery(function($) {

    $('ul.category-picker li').bind('click', function(e) {

        var deselect_this = false;
        var li = $('a', this);
        var href = li.attr('href');

        if($(this).hasClass('Matched')) {
            deselect_this = true;
            $(this).removeClass("Matched");
        } 

        $(this).parent().children().each(function() {
            $(this).removeClass("Matched");
        });

        if(!deselect_this) {
            $(this).addClass('Matched');
        }
        //TODO: maaaaaan clean this up!
        $(this).parents('.category-picker-holder').siblings('.feature, .check').removeAttr('style').attr('state', 0);
        //$(this).parents('.g4of5').siblings('.status-message').html('<span style="background-color: #3a4c5c; color: #f0f0f0">FILE AS: '+li.text()+"</span>");
        //$.ajax( { type: "POST", url: href } );
        e.preventDefault();
    });

    $('div.category-picker-holder').hide();

    $('.fileas').bind('click', function(e) {     
        $(this).siblings('div.category-picker-holder').toggle(); 
        e.preventDefault();
    });

    $('select[name="status"], select[name="priority"]').hide();
    $('div.undo-bar').hide(); 
    //$('.check').switcharoo('0px bottom');
    //$('.feature').switcharoo('-60px bottom');
    var feed_holder;
    $('.check, .feature, .remove, li > a.cat-picks').bind("click", function() {
        var message, mode;
        var feedid = $(this).attr('feedid');      
        var href   = $(this).attr('hrefaction'); 
        var catid  = $(this).attr('catid');
        var feeds  = {"feedid": feedid};
        var identifier = $(this).attr('class');
        var state  = $(this).attr('state');

        feed_holder = feeds;
        
        var currentUrl = $(location).attr('href');
        var baseUrl    = $('select[name="delete_selection"]').attr('base-url');             

        if(identifier == 'check') {
            message = "Feedback has been published and moved to " + "<a href='" +baseUrl+ "inbox/published/all'>Published Folder</a>";
            mode    = "publish";
        }

        if(identifier == 'feature') { 
            message = "Feedback has been published and moved to " + "<a href='" +baseUrl+ "inbox/featured/all'>Featured Folder</a>"; 
            mode    = "feature"; 
        }

        if(identifier == 'remove') { 
            message = "Feedback has been " + "<a href='" +baseUrl+ "inbox/deleted'>deleted</a>"; 
            mode    = "delete";
        }

        if(identifier == 'cat-picks') {
            message = "Feedback has been sent to " + "<a href='" +baseUrl+ "inbox/filed/all'>Filed Feedback</a>";  
            mode    = "fileas";
            console.log($(this).parents('div.category-picker-holder').hide());
        }

        $(this).parents('.feedback').fadeOut(700, function() {
            var notify_msg = message + " <a class='undo' hrefaction='" + href + "' href='#' undo-type='" + identifier + "'>undo</a>";
            var notify     = $('<div/>').addClass(identifier).html(notify_msg);
            var chck_find  = $('.checky-bar').find("."+identifier);
            
            if(state == 0) { 
                $('.checky-bar').html(notify).show();
            }
        });
        mode = ((state == 0) ? mode : "inbox");
        $.ajax( { type: "POST", url: href, data: {"mode": mode ,"feed_ids": [feeds], "cat_id": catid } } );
    });

    $('a.undo').live('click', function(e) {
        var feedid    = $(this).attr('href');
        var href      = $(this).attr('hrefaction'); 
        var undo_type = $(this).attr('undo-type');
        
        $("#" + feed_holder.feedid).fadeIn(700);
        $(this).parents("."+undo_type).fadeOut(300, function() { $(this).remove(); }); 
        $.ajax( { type: "POST", url: href, data: {"mode": "inbox", "feed_ids": [feed_holder]} } );  
        e.preventDefault(); 
    });

    $('.flag').switcharoo('-100px bottom');
       
    $.each($('ul#nav-menu li'), function(index, value) {
        $(value).bind('click', function(e) {
            window.location = $(this).children('a').attr('href');
        });
    });

    $('select[name="feedback-limit"]').bind('change', function(e) {
        window.location = "?limit=" + $(this).val();
    });

    $('select[name="rating-limit"]').bind('change', function(e) {
        window.location = "?rating=" + $(this).val();
    });
    
    var userInfo = new FeedbackDisplayToggle({feed_id: $('#feed-id'), hrefaction: $('#toggle_url')});
    userInfo.toggleDisplays($('.user-info input[name*="display"]'), 'feedid');
    userInfo.toggleDisplays($('.display-info input[name*="display"]'), 'feedblock_id');

    var check = new Checky({   delete_selection: $('.delete-selection')
                             , check_feed_id: $('.check-feed-id')
                             , contact_feed_id: $('.contact-feed-id')
                             , site_feed_id: $('.site-feed-id')
                             , click_all: $('.click-all')  });
    check.init(); 
    check.clickAll();

    var statusChange = new DropDownChange({status_element: $('span.status-change'), status_selector: 'change.status'});
    statusChange.enable();

    var priorityChange = new DropDownChange({status_element: $('span.priority-change'), status_selector: 'change.priority'});
    priorityChange.enable();
});
