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
        e.preventDefault();
    });

    $('div.category-picker-holder').hide();

    //check theme 1 by default
    $("#themeId_1 input:radio").attr('checked', true);

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

        if(href){ 
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
        }
       
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

    $('.flag').switcharoo('-100px 0px');
       
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
    

    $('#feedsetup-site-select').bind('change', function(e) {
        var me = this;
        $.ajax({
            type: "POST"     
          , url: $(me).attr('hrefaction')
          , data: {site_id: $(me).val()}
          , success: function(msg) {
              $("#display-info-target").html(msg);             
          }
        })


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

    $('.check').fancytips();
    $('.fileas').fancytips();
    $('.reply').fancytips();
    $('.feature').fancytips();
    $('.contact').fancytips();
    $('.flag').fancytips();
    $('.remove').fancytips({'top': 45});
    
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
	
    $("#preview-widget").bind("click", function(e) {
        var me = this;
        var embed_choices, iframe_code;
        var padding = 10;
        var embed_width  = $('input[name="embed_width"]').val() > 0 ? parseInt($('input[name="embed_width"]').val(), 10) + padding : 750;
        var embed_height = $('input[name="embed_height"]').val() > 0 ? parseInt($('input[name="embed_height"]').val(), 10) + padding : 440;
        var site_id      = $('input[name="site_id"]').val() > 0 ? $('input[name="site_id"]').val() : $('select[name="site_id"]').val();
        var embed_type = $("input:radio[name='embed_type']:checked").val();
        var company_id = $("input[name='company_id']").val();
        var theme_id = $("input:radio[name='theme_id']:checked").val();
        var embed_choices;

        embed_choices = embed_choice_check(embed_type);

        $.ajax({
            url: $(me).attr('hrefaction')
          , data: "siteId=" + site_id + "&companyId=" + company_id + "&themeId=" + theme_id + "&embed_type=" + embed_type + embed_choices
          , dataType: 'html'
          , success : function(msg) {
              s36Lightbox(embed_width, embed_height, msg); 
          }
        });
     
        
    });
    
    $("#horizontal_embed, #vertical_embed").bind('click', function() {
        var click_type = $(this).attr('id');

        if(click_type == 'horizontal_embed') {
            set_height_width(600, 300);
        }

        if(click_type == 'vertical_embed') {
            set_height_width(250, 500);
        }

        function set_height_width(x, y) {
            $('input[name="embed_width"]').val(x);
            $('input[name="embed_height"]').val(y);  
        }

    });

    $("#generate-feedback-btn").bind("click", function(e) {
        var me = this;
        var site_id = $("input[name='site_id']").val() ? $("input[name='site_id']").val() : $("select[name='site_id']").val();
        var company_id = $("input[name='company_id']").val();
        var embed_type = $("input:radio[name='embed_type']:checked").val();
        var theme_id = $("input:radio[name='theme_id']:checked").val();
        var embed_choices;

        embed_choices = embed_choice_check(embed_type);

        $.ajax({
            url: $(me).attr('hrefaction')
          , data: "getJSON=1&siteId=" + site_id + "&companyId=" + company_id + "&themeId=" + theme_id + "&embed_type=" + embed_type + embed_choices
          , dataType: 'json'
          , success : function(msg) {
              $("#code-generate-view").val(msg.init_code);             
              $("#widget-generate-view").val(msg.widget_code);
          }
        });

        e.preventDefault();
    })

    $('a.get-code').bind('click', function(e) {  
        var url = $(this).attr('href');  
        $.ajax({
            url: url
          , success : function(msg) {
              s36Lightbox(500, 420, msg);
          }
        });
        return e.preventDefault();  
    });

    $('input[type="button"].edit, input[type="button"].delete').bind('click', function(e) {
        var hrefaction = $(this).attr('hrefaction');
        var input_class = $(this).attr('class');
        var input_parents = $(this).parents('tr');
        var ajax_action;

        if(input_class == 'delete') {
            if(confirm("Are you sure you want to delete this theme?")) {
                input_parents.fadeOut(400);     
                $.post(hrefaction, function(msg) { console.log(msg); });           
            }
        } 

        if(input_class == 'edit') {
            $.getJSON(hrefaction, function(msg) { s36Lightbox(msg.width, msg.height, msg.view);/*console.log(msg);*/ });                
        }
         
        e.preventDefault();
    });
     
    $('a.perm-delete').click(function(e) { 
        if(confirm("Are you sure you want to permanently delete this feedback?")) {
            return true;
        } 
        e.preventDefault();
    });
    //helper functions
    function embed_choice_check(embed_type) {

        var embed_choice_string;

        if(embed_type == 'fullpage') {
            embed_choice_string = "&units=" + $('select[name="full_page_units"] option:selected').val();
        }

        if(embed_type == 'embedded') {
            embed_choice_string = "&type=" + $('input[name="embed_block_type"]:checked').val() + "&width=" + $('input[name="embed_width"]').val() + "&height=" + $('input[name="embed_height"]').val();
            embed_choice_string += "&effect=" + $('select[name="embed_effects"] option:selected').val() + "&units=" + $('select[name="embed_units"] option:selected').val();
        }

        if(embed_type == 'modal') {
            embed_choice_string = "&effect=" + $('select[name="modal_effects"] option:selected').val();
        }

        if(!embed_choice_string) { 
            alert("Please choose a Widget.");
            return false;
        }

        return embed_choice_string; 
    }

    function s36Lightbox(width, height, insertContent) {	
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

    var jcrop_api, set_image;

    function initJcrop() { 
        $('#jcrop_target').Jcrop({
            setSelect: ['40','20','190','170']
          , boxWidth: 350
          , boxHeight: 230
          , aspectRatio: 1
          , onChange: showPreview
          , onSelect: showPreview
        }, function() {
            jcrop_api = this;  
        });
    }

    function showPreview(coords) {

        var rx = 100 / coords.w;
        var ry = 100 / coords.h;
        var target = $('#jcrop_target');
        var hgt = target.height();
        var wdt = target.width();
        
        $('#x').val(coords.x);
        $('#y').val(coords.y);
        $('#w').val(coords.w);
        $('#h').val(coords.h);
        
        $('#preview').css({
            width: Math.round(rx * wdt) + 'px',
            height: Math.round(ry * hgt) + 'px',
            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
            marginTop: '-' + Math.round(ry * coords.y) + 'px'
        });
    };

    function save_crop_image(){
        var fb_login = $("#fb_flag").val();
        var x_coords = $('#x').val();
        var y_coords = $('#y').val();
        var wd = $('#w').val();
        var ht = $('#h').val();
        var cropped_photo = $('#preview').attr('src');
        var status = $('#crop_status');
        var oldphoto = $('input[name="cropped_image_nm"]').val();
        
        status.html(' Cropping Photo...');
        
        return $.ajax({
            url: $("#ajax-crop-url").attr('hrefaction'),
            method: 'GET',
            async: false,
            data: "&src="+cropped_photo+"&x_coords="+x_coords+"&y_coords="+y_coords+"&wd="+wd+"&ht="+ht+"&oldphoto="+oldphoto+"&fb_login="+fb_login,
            success: function(data){
                status.fadeOut('fast',function(){
                    status.html(' <img src="/img/check-ico.png" /> Photo Successfully Cropped! ');
                    status.fadeIn();
                    //set to signify photo has already been uploaded and in case of another photo upload will delete old photo
                    $('input[name="cropped_image_nm"]').val(data);
                });
            }
        });
    }

    $('div.adjust-crop').hide();
    $(document).delegate("#your_photo", "change", function() {   
		$.ajaxFileUpload ({
            url: $("#ajax-upload-url").attr('hrefaction'),
            secureuri:false,
            fileElementId:'your_photo',
            dataType: 'json', 
            success: function (data, status) {	  
                var file = "/" + data.dir;
                var width = Math.round(data.wid);
                var jcrop_div = $("div.jcrop_div");
                var existing_avatar = $('input[name="existing_avatar"]');

                $('div.adjust-crop').show();

                $('#profile_picture').attr('src',file);
                $('#jcrop_target').attr('src',file);
                $('#preview').attr('src',file);

                if(jcrop_api) {
                    jcrop_api.setImage($('#profile_picture').attr('src'));
                    jcrop_api.setSelect(['40','20','190','170']);
                }

                if(existing_avatar.length > 0) {
                    $.post($("#ajax-delete-existing-avatar").attr('hrefaction'), {avatar: existing_avatar.val()});
                }

                jcrop_div.css({'width':width});
                $('input[name="orig_image_dir"]').val(file); 
                initJcrop();
            }
		}); 
    });

    $('#cropbtn').click(function(){ 
        save_crop_image(); 
    });

    $('a.save').hide();
    $('a.edit').bind("click", function(e) {
        var me = this;
        var textarea = $('.feedback-textarea');
        var hrefaction = textarea.attr('hrefaction');

        $(me).hide();
        textarea.removeAttr('disabled');
        
        $('a.save').show().unbind('click.save').bind("click.save", function(e) { 
            var feed_id = $('#feed-id').val();
            $(this).hide();
            $(me).show();
            textarea.attr('disabled', 'disabled');
            $.post(hrefaction, { feed_id: feed_id, feedback_text: textarea.val() });
            e.preventDefault();
        });
 
        e.preventDefault();
    });

    $('a.admin-delete').bind("click", function(e) {
        console.log($(this).attr('href'));
        if(confirm("Are you sure you want to delete this user? There is no undo.")) { 
            return true;
        } 
        e.preventDefault();
    })
});
