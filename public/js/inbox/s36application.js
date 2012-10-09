jQuery(function($) { 
    /*
    $('.admin-nav-bar').delegate('li a', 'click', function(e) {
        var url = $(this).attr('href');
        var deselect_this = false;

        $(this).parent().siblings().children('a').each(function() {
            $(this).removeClass("selected");     
        });

        if(!deselect_this) {
            $(this).addClass('selected');
        }

        $.pjax({
            url: url
          , container: '.the-feedbacks'
          , success: function() { 
              $('.status-change > select, .priority-change > select, div.category-picker-holder, div.fast-forward-holder, .ff-form, #notification-message').hide();
          }
        });

        e.preventDefault();
    });
    */
    $(document).delegate(".feedback-avatar", "hover", function(e) {
        if (e.type === "mouseenter")  {
            $('.large-avatar', this).show();
        } else { 
            $('.large-avatar', this).hide();
        }
    });

    $(document).delegate("a.cat-picks", "click", function(e) {

        var deselect_this = false;

        $(this).parent().siblings().children('a').each(function() {
            $(this).removeClass("Matched");     
        });

        if(!deselect_this) {
            $(this).addClass('Matched');
        }
 
        var catpick = new CatPickObject($(this));
        catpick.process();
        catpick.undo();

        e.preventDefault();
    });

    $(document).delegate("a.menubtn", "click", function(e) {

        var deselect = false;

        $(this).parent().children('a.menubtn').each(function() {
            $(this).removeClass("matched");     
        });

        if(!deselect) {
            $(this).addClass('matched');
        }

        $.ajax({url: "/feedback/bust_hostfeed_data"}); 

        $.ajax({
            type: "GET"     
          , url: $(this).attr('href')
          , success: function(msg) {
                var myStatus = new Status();
                myStatus.notify("Processing...", 2000);
            }
        }) 

        e.preventDefault();
    })

    //for modify feedback bit    
    $(document).delegate("a.flagged", "click", function(e) {
        $(this).toggleClass("matched");

        var state = $(this).attr('state');
        var var_state;
        if(state == 0) { 
            $(this).attr('state', 1);
            var_state = 1;
        } else { 
            $(this).attr('state', 0);
            var_state = 0;
        }

        $.ajax({
            type: "GET"     
          , data: {"state": var_state}
          , url: $(this).attr('href')
          , success: function(msg) { 
                var myStatus = new Status();
                myStatus.notify("Processing...", 1000);
            }
        }) 

        e.preventDefault();
    });

    $(document).delegate("a.delete", "click", function(e) {
        if(confirm("Are you sure you want to delete this feedback?")) {
            return true;
        } 
        e.preventDefault();
    });
     
    //check theme 1 by default
    $("#themeId_1 input:radio").attr('checked', true);
    
    //FastForward Email Block...fuck this is a mess...
    $(".ff-form").hide();
    var mouse_is_inside = false;
    $('.contact, .fileas, .forward').hover(function() {
        mouse_is_inside = true;  
    }, function() {
        mouse_is_inside = false;
    });

    $(document).delegate(".fileas", "click", function(e) {
        var id = $(this).attr('id');
        $('#' + id + ' div.category-picker-holder').show().hover(function() { 
            mouse_is_inside = true;  
        }, function() { 
            mouse_is_inside = false;    
        });
        e.preventDefault();
    })

    $('textarea[name="email_comment"]').bind("focus", function() {
        $(this).val("");
    })
    
    //fucking bug where in for some reason jquery cannot select the div.fast-forward-holder element when using the forward class name.   
    $(document).delegate(".contact, .forward", "click", function(e) {
        var id = $(this).attr('id'); 
        var selector;

        var class_name = $(this).attr('class');

        if(class_name == 'contact') {
            selector = $('#' + id + ' div.fast-forward-holder');
        }

        if(class_name == 'forward') {
            selector = $('#' + id);
        }

        selector.show()
        .hover(function() { 
            $('div.email-list > ul.email-picker li[id^=email]', this)
            .live('click', function() {
                var me = $(this);
                me.parent().hide()
                       .siblings('.ff-form')
                       .ajaxForm({
                            success: function() {
                                me.parents('div.fast-forward-holder').hide().end()
                                  .parents('.email-picker').show().end()
                                  .parent().siblings('.ff-form').hide().children('.ff-forward-to').html("").end();
                                $('textarea[name="email_comment"]').val("");
                                alert("Fast-forward sent to " + $('a', me).text());
                            }
                        })
                           .children('.ff-forward-to').html($(this).html()).end()
                           .children('input[name="email"]').val($('a', this).html()).end()
                       .show();
            });
            mouse_is_inside = true;  
        }, function() {
            mouse_is_inside = false;    
        });      
        e.preventDefault();
    })

    $("body").click(function() { 
        if(!mouse_is_inside) {
            $('div.fast-forward-holder, div.category-picker-holder, .ff-form, .checky-bar').hide();      
            $('.email-picker').show();
            $('textarea[name="email_comment"]').val("");
        } 
    });

    //End of FastForward
    new InboxStatusChange('.check, .feature, .remove, .popup-delete').initialize(); 
    $('div.undo-bar').hide(); 

    //TODO: Please update
    $('.flag').switcharoo('-100px 0px');
       
    $.each($('ul#nav-menu li'), function(index, value) {
        $(value).bind('click', function(e) {
            window.location = $(this).children('a').attr('href');
        });
    });
     
    var check = new Checky({   
        feed_selection: '.feed-selection'
      , check_feed_id: '.check-feed-id'
      , category_feed_id: '.category-feed-id'
      , click_all: '.click-all'
    });

    check.init(); 
    check.clickAll();

    var statusChange = new DropDownChange({status_element: 'span.status-change', status_selector: 'change.status'});
    statusChange.enable();
    var priorityChange = new DropDownChange({status_element: 'span.priority-change', status_selector: 'change.priority'});
    priorityChange.enable();

    $('.check').fancytips();
    $('.fileas').fancytips();
    $('.reply').fancytips();
    $('.feature').fancytips();
    $('.contact').fancytips();
    $('.flag').fancytips();
    $('.remove').fancytips({'top': 45});
    
    $('a.perm-delete').click(function(e) { 
        if(confirm("Are you sure you want to permanently delete this feedback?")) {
            return true;
        } 
        e.preventDefault();
    });

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

    $('div.adjust-crop').hide();
    /*
    $("#your_photo").fileupload({
        dataType: 'json'  
      , done: function(e, data) {
            console.log(data.result);
        }
    });
    */

    $(document).delegate("#your_photo", "change", function() {   
		$.ajaxFileUpload ({
            url: $("#ajax-upload-url").attr('hrefaction'),
            secureuri:false,
            fileElementId:'your_photo',
            dataType: 'json', 
            success: function (data, status) {	  

                var myStatus = new Status();
                myStatus.notify("Photo Upload Success!", 1000);

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
        var x_coords = $('#x').val();
        var y_coords = $('#y').val();
        var wd = $('#w').val();
        var ht = $('#h').val();
        var cropped_photo = $('#preview').attr('src');
		var crop_status = $('#crop_status');  
		var oldphoto = $('#cropped_photo').val();	
        var data = {src: cropped_photo, x_coords: x_coords, y_coords: y_coords, wd: wd, ht: ht, oldphoto: oldphoto, login_type: 36};
        crop_status.html(' Cropping Photo...');

        $.ajax({
            url: $("#ajax-crop-url").attr('hrefaction')
          , type: 'POST'
          , data: data 
          , success: function(data){
              $('#cropped_photo').val(data);
              $("#profile_picture").attr('src', "/uploaded_cropped/150x150/" + data); 
              var myStatus = new Status();
              myStatus.notify("Your photo is successfully cropped! If you feel this is the right photo for you please click on the Save Settings button.", 4000);
              crop_status.hide();
              $('div.adjust-crop').hide();
           }
        });
    });

    $(document).delegate('a.save-feedback-text', 'click', function(e) { 

        var textarea = $('.feedback-textarea');
        var feed_id = $('#feed-id').val();

        $.ajax({
            url: '/feedback/edit_feedback_text'              
          , type: 'POST'
          , dataType: 'json'
          , data: { feed_id: feed_id, feedback_text: textarea.val() } 
          , success: function(msg) { 
               
                if(msg) {
                    alert(msg.error);
                } else { 
                    var myStatus = new Status();
                    myStatus.notify("Processing...", 1000);
                }

            }
        });

        e.preventDefault();
    });

    $('a.admin-delete').bind('click', function(e) {
        if(confirm("Are you sure you want to delete this user? There is no undo.")) { 
            return true;
        } 
        e.preventDefault();
    });

    $('.contact-edit').bind('click', function(e) {
        var href = $(this).attr('hrefaction');
        window.location = href;
        e.preventDefault();
    });

    $('.contact-delete').bind('click', function(e) {
        var hrefaction= $(this).attr('hrefaction');
        var that = this;
        if(confirm("Are you sure you want to delete this user? There is no undo.")) { 
            $.get(hrefaction, function(msg) { 
                $(that).parents('tr').fadeOut(350);
            });           
        }
        e.preventDefault();
    });

    $('.copycheck').hide();
    $("#widget-preview").hide();
    new ZClip();
    
    //TODO: WORK ON THIS
    $(document).delegate('.catmenu-status, .catmenu-priority', 'change', function(e) {
        console.log($(this).val()); 
    });

    $(document).delegate('.feedback-data-table input[type=checkbox]', 'click', function(e) {
        var column_name = $(this).attr('name');
        var check_val = $(this).attr('checked');
        var feedid = $('.fast-forward-holder').attr('id');

        $.ajax({url: "/feedback/bust_hostfeed_data"}); 

        $.ajax({ 
            type: "POST"     
          , url: '/feedback/toggle_feedback_display'//$("#toggle_url").attr("hrefaction")
          , data: {column_name: column_name, check_val: check_val, feedid: feedid}
          , success: function(msg) {
                var myStatus = new Status();
                myStatus.notify("Processing...", 750);
            }
        })
    });

    $(document).delegate('.feedback-data input[type=checkbox]', 'click', function(e) {
        var check_val = $(this).attr('checked');
        var feedid = $('.fast-forward-holder').attr('id');     

        $.ajax({ 
            type: "POST"     
          , url: $("#indlock_url").attr("hrefaction")
          , data: {check_val: check_val, feedid: feedid}
          , success: function(msg) {
                var myStatus = new Status();
                myStatus.notify("Processing...", 750);
            }
        })
    });
});
