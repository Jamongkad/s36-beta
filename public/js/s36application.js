jQuery(function($) {

    $('a.cat-picks').bind('click', function(e) {

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

    $('a.menubtn').bind('click', function(e) { 

        var deselect = false;

        $(this).parent().children('a.menubtn').each(function() {
            $(this).removeClass("matched");     
        });

        if(!deselect) {
            $(this).addClass('matched');
        }

        $.ajax({
            type: "GET"     
          , url: $(this).attr('href')
          , success: function(msg) {
                var myStatus = new Status();
                console.log("mathew");
                myStatus.notify("Processing...", 10000);
            }
        }) 

        e.preventDefault();
    })

    $('a.flagged').bind("click", function(e) { 
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

    $('a.delete').bind("click", function(e) { 
        if(confirm("Are you sure you want to delete this feedback?")) {
            return true;
        } 
        e.preventDefault();
    });

    $('.reply').bind("click", function(e) {     
        var href = $(this).attr('hrefaction');
        window.location = href;
        e.preventDefault();
    })
    
    var seen = {};
    $('.add-bcc > li').bind("click", function(e) {
        var pointer = $(this).index();
        var input = "<input type='text' name='bcc[]' value='"+$(this).text()+"' />  <a class='delete-bcc' id='" + pointer + "' href='#'>[x]</a>";       

        if(typeof seen[pointer] == 'undefined') {  
           $("#bcc-target").append(input);
           seen[pointer] = true;
        }         
        
        $(".delete-bcc").unbind("click.delete-bcc").bind("click.delete-bcc", function(e) {
            var del_pointer = $(this).attr('id');
            $(this).prev('input').remove().end().remove();
            delete seen[del_pointer];
            e.preventDefault();
        })
        
        e.preventDefault();
    })

    //check theme 1 by default
    $("#themeId_1 input:radio").attr('checked', true);
    
    //FastForward Email Block...fuck this is a mess...
    $('div.category-picker-holder, div.fast-forward-holder, .ff-form, #notification-message').hide();
    var mouse_is_inside = false;
    $('.contact, .fileas, .forward').hover(function() {
        mouse_is_inside = true;  
    }, function() {
        mouse_is_inside = false;
    });

    $('.fileas').bind('click', function(e) { 
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
    $('.contact, .forward').bind('click', function(e) { 
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
            $('div.email-list > ul.email-picker li', this)
            .bind('click', function() {
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
            $('div.fast-forward-holder, div.category-picker-holder, .ff-form').hide();      
            $('.email-picker').show();
            $('textarea[name="email_comment"]').val("");
        } 
    })

    //End of FastForward
    new InboxStatusChange($('.check, .feature, .remove, .popup-delete')).initialize(); 
    $('div.undo-bar').hide(); 
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
    
    var userInfo = new FeedbackDisplayToggle({feed_id: $('#feed-id'), hrefaction: $('#toggle_url')});
    userInfo.toggleDisplays($('.user-info input[name*="display"]'), 'feedid');
    
    var checkyBar = $('.checky-bar');
    //checkyBar.hide();
    var check = new Checky({   feed_selection: $('.feed-selection')
                             , check_feed_id: $('.check-feed-id')
                             , category_feed_id: $('.category-feed-id')
                             , click_all: $('.click-all')
                             , checky_bar: checkyBar });
    check.init(); 
    check.clickAll();


    $('.status-change > select, .priority-change > select').hide();

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
    
    $('a.perm-delete').click(function(e) { 
        if(confirm("Are you sure you want to permanently delete this feedback?")) {
            return true;
        } 
        e.preventDefault();
    });

    CategoryControl();

    $('a.add-new-ctgy').bind("click", function(e) {
        var ctgy_nm = $("input[name='category_nm']");
        var ctgy_list = $("#ctgy-list");
        
        if(ctgy_nm.val() == false) 
            alert("Category Name cannot be blank.");           
        else 
            $.ajax({
                url: ctgy_list.attr('hrefaction')
              , type: "POST" 
              , data: {ctgy_nm: ctgy_nm.val(), companyId: $("input[name='companyid']").val()}
              , success: function(msg) {
                  ctgy_list.append(msg);
                  ctgy_nm.val("");
                  CategoryControl();
              }
            }); 
       
        e.preventDefault();
    })

    function CategoryControl() {
       $('a.rename-ctgy, a.delete-ctgy').unbind('click.ctgy-controls').bind('click.ctgy-controls', function(e) {
           var class_name = $(this).attr('class');
           var that = $(this);

           if(class_name == 'rename-ctgy') {
               var input = $('<input type="text" name="ctgy_nm"/>').val(
                   that.parents('div').siblings('div').children('.ctgy-name').html()
               );

              if(that.text() == "Update") {
                  var ctgy_nm_val = $('input[name="ctgy_nm"]').val()
                  console.log("Rename");
                  that.text("Rename") 
                        .parents('div')
                        .siblings('div')
                        .children('.ctgy-name')
                        .html( ctgy_nm_val ).end().end().end()
                  $.ajax({ url: that.attr('href'), type: "POST", data: {ctgy_nm: ctgy_nm_val} });
              } else {
                  that.text("Update")     
                        .parents('div')
                        .siblings('div')
                        .children('.ctgy-name')
                        .html( input ).end().end().end()
              }
              
           }

           if(class_name == 'delete-ctgy') {
              var d = that.parents('div.grids');
              if(confirm("Are you sure you want to delete this category? There is no undo.")) {
                  $.ajax({ url: $(this).attr('href'), success: function(msg) { d.fadeOut(); } });
              }
           }

           e.preventDefault();
       })
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
        
        $.ajax({
            url: $("#ajax-crop-url").attr('hrefaction'),
            method: 'GET',
            async: true,
            data: "&src="+cropped_photo+"&x_coords="+x_coords+"&y_coords="+y_coords+"&wd="+wd+"&ht="+ht+"&oldphoto="+oldphoto+"&fb_login="+fb_login,
            success: function(data){
                status.fadeOut('fast',function(){
                    //status.html(' <img src="/img/check-ico.png" /> Photo Successfully Cropped! ');
                    //status.fadeIn();
                    //set to signify photo has already been uploaded and in case of another photo upload will delete old photo
                    $('input[name="cropped_image_nm"]').val(data);
                });

                var myStatus = new Status();
                myStatus.notify("Your photo is successfully cropped! If you feel this is the right photo for you please click on the Save Settings button.", 7000);

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
            $.post(hrefaction, { feed_id: feed_id, feedback_text: textarea.val() }, function(msg) { 
                var myStatus = new Status();
                myStatus.notify("Processing...", 1000);
            });
            e.preventDefault();
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
    
    $(".pagination a").live("click", function(e) {
        var url = $(this).attr('href');
        $.getJSON(url, function(data) {
            $("#overview-target").html(data.view);
        });

        e.preventDefault();
    });
});
