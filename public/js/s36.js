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
    var feed_holder, new_mode;
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

        $(this).parents('.feedback').fadeOut(350, function() {
            var undo       = " <a class='undo' hrefaction='" + href + "' href='#' undo-type='" + identifier + "'>undo</a>";
            var notify_msg = message + undo; 
            var notify     = $('<div/>').addClass(identifier).html(notify_msg);
            //var chck_find  = $('.checky-bar').find("."+identifier);
            
            if(state == 0) {  
                $('.checky-bar').html(notify).show();
                $.ajax( { type: "POST", url: href, data: {"mode": mode ,"feed_ids": [feeds], "cat_id": catid } } );
            } else { 
                new_mode = mode;
                $('.checky-bar')
                .html("<div class='" + identifier + "'>Feedback has been sent to the " + "<a href='" + baseUrl + "inbox/all'>Inbox</a> " + undo + "</div>")
                .show();
                $.ajax( { type: "POST", url: href, data: {"mode": "inbox" ,"feed_ids": [feeds], "cat_id": catid } } );
            }
        });
    });

    $('a.undo').live('click', function(e) {
        var feedid    = $(this).attr('href');
        var href      = $(this).attr('hrefaction'); 
        var undo_type = $(this).attr('undo-type');
        var mode      = (new_mode) ? new_mode : "inbox";
        var sec       = 350;

        //generic feedback return 
        $("#" + feed_holder.feedid).fadeIn(sec);
        $(this).parents("."+undo_type).fadeOut(sec, function() { $(this).remove(); }); 

        $.ajax( { type: "POST", url: href, data: {"mode": mode, "feed_ids": [feed_holder]} } );  
        e.preventDefault(); 
    });

    $('.flag').switcharoo('-100px bottom');
       
    $.each($('ul#nav-menu li'), function(index, value) {
        $(value).bind('click', function(e) {
            window.location = $(this).children('a').attr('href');
        });
    });


    $('select[name="site_choice"]').bind('change', function(e) {
        var select = $(this).val();
        window.location = (select == 'all') ? "all" : "?site_id=" + $(this).val();
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

    $('.check').fancytips({'text': 'Publish Feedback', 'width': 85});
    $('.fileas').fancytips({'text': 'Categorize Feedback'});
    $('.reply').fancytips({'text': 'Reply To', 'width': 40});
    $('.feature').fancytips({'text': 'Feature Feedback', 'width': 85});
    $('.contact').fancytips({'text': 'Fast Forward', 'width': 60});
    $('.flag').fancytips({'text': 'Fast Forward', 'width': 70});
    $('.remove').fancytips({'top': 45, 'width': 84 ,'text': 'Delete Feedback'});
    /*
    $('#template-slider').cycle({
        fx:      'scrollHorz', 
        speed:    500, 
        timeout:  0 ,
        pause : 1,
        next:   '#next', 
        prev:   '#prev',
        after: adjust_height
    });
    */
    
    //TODO: Clean this shit up
    $('#full_page_widget').hide();
    $('#embed_widget').hide();
    $('#modal_widget').hide();
     
    $('#full_page_type').click(function(){
        $('#full_page_widget').slideDown();
        $('#embed_widget').slideUp();
        $('#modal_widget').slideUp();

        
        $("#embed_widget tr td").children('select, input[type="text"]').val(0).end()
                                .children('input[type="radio"]').attr('checked', null);                   

        $("#modal_widget tr td").children('select').val(0);
    });
    $('#embed_type').click(function(){
        $('#full_page_widget').slideUp();
        $('#embed_widget').slideDown();
        $('#modal_widget').slideUp();

        $("#full_page_widget tr td").children('select').val(0);
        $("#modal_widget tr td").children('select').val(0);
    });
    $('#modal_type').click(function(){
        $('#full_page_widget').slideUp();
        $('#embed_widget').slideUp();
        $('#modal_widget').slideDown();

        $("#full_page_widget tr td").children('select').val(0); 
        $("#embed_widget tr td").children('select, input[type="text"]').val(0).end()
                                .children('input[type="radio"]').attr('checked', null);                   
    });
	
	function adjust_height(curr, next, opts, fwd) {
		var index = opts.currSlide;
		var $ht = $(this).height();
		$(this).parent().animate({height: $ht},200);
	}

    $("#preview-widget").bind("click", function(e) {
        var embed_width = $('input[name="embed_width"]').val() > 0 ? $('input[name="embed_width"]').val() : 500;
        var embed_height = $('input[name="embed_height"]').val() > 0 ? $('input[name="embed_height"]').val() : 500;
        var site_id = $('input[name="site_id"]').val() > 0 ? $('input[name="site_id"]').val() : $('select[name="site_id"]').val();

        //build dynamic string builder for widget preview creation...

        s36Lightbox(embed_width, embed_height, "<iframe src='/widget/test?site_id="+site_id+"' width='"+embed_width+"' height='"+embed_height+"'></iframe>"); 
    });

    function s36Lightbox(width,height,insertContent){	
        if($('#lightbox').size() == 0){
            var theLightbox = $('<div id="lightbox"/>');
            var theShadow = $('<div id="lightbox-shadow"/>');
            $(theShadow).click(function(e){
                closeLightbox();
            });
            $('body').append(theShadow);
            $('body').append(theLightbox);
        }
        $('#lightbox').empty();
        if(insertContent != null){
            $('#lightbox').append(insertContent);
        }
        
        //set negative margin for dynamic width
        var margin = Math.round(width / 2);
        
        // set the css and show the lightbox
        $('#lightbox').css('top', $(window).scrollTop() + 100 + 'px');
        $('#lightbox').css({
                            'width':width,
                            'height':height,
                            'margin-left':"-"+margin+"px"
                            });
                            
        $('#lightbox').fadeIn('fast');
        $('#lightbox-shadow').fadeIn('fast');
    }

    function closeLightbox(){
        $('#lightbox').fadeOut('fast',function(){$(this).empty();});
        $('#lightbox-shadow').fadeOut('fast');
    }

    $("#generate-feedback-btn").bind("click", function(e) {
        var me = this;
        var site_id = $("input[name='site_id']").val() ? $("input[name='site_id']").val() : $("select[name='site_id']").val();
        var company_id = $("input[name='company_id']").val();
        $.ajax({
            url: $(me).attr('hrefaction')
          , data: "siteId=" + site_id + "&" + "companyId=" + company_id
          , success : function(msg) {
              $("#code-generate-view").val(msg);             
          }
        });

        e.preventDefault();
    })
});
