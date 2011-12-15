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
        $(this).parents('.category-picker-holder')
               .siblings('.feature, .check')
               .removeAttr('style')
               .attr('state', 0);
        e.preventDefault();

    });

    //check theme 1 by default
    $("#themeId_1 input:radio").attr('checked', true);
    
    //FastForward Email Block...fuck this is a mess...
    $('div.category-picker-holder, div.fast-forward-holder, .ff-form').hide();
    var mouse_is_inside = false;
    $('.contact, .fileas').hover(function() {
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

    $('.contact').bind('click', function(e) { 
        var id = $(this).attr('id');
        $('#' + id + ' div.fast-forward-holder').show().hover(function() { 
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
    $('select[name="status"], select[name="priority"]').hide();
    $('div.undo-bar').hide(); 
    
    new InboxStatusChange($('.check, .feature, .remove, .popup-delete, li > a.cat-picks')).initialize(); 

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
                             , category_feed_id: $('.category-feed-id')
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
                  console.log("Update");
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
    
});
