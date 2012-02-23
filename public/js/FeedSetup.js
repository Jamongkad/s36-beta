jQuery(function($) {

    $("#create-widget").on("submit", function(e) {
        $(this).ajaxSubmit({
            dataType: 'json'
          , beforeSubmit: function(formData, jqForm, options) {
                new Status().notify("Processing...", 1000); 
            }
          , success: function(responseText, statusText, xhr, $form) {  
                var error = isDefined(responseText, 'errors') ? responseText.errors : false;
                var theme_name = $("div#theme_name");
                var site_id    = $("div#site_id");
                var embed_type = $("div#embed_type");
                var widget_options = $("div#widget_options");                

                if(error) {
                    if(error.messages.theme_name) {
                        theme_name.html(error.messages.theme_name[0]);     
                        $.scrollTo('input[name="theme_name"]', 800);
                    } else { 
                        theme_name.html("");
                    }
                  
                    if(error.messages.site_id) {
                        site_id.html(error.messages.site_id[0]);                   
                        $.scrollTo('input[name="theme_name"]', 800);
                    } else { 
                        site_id.html("");
                    }

                    if(error.messages.embed_type) {
                        embed_type.html(error.messages.embed_type[0]);     
                        $.scrollTo('input[name="theme_name"]', 800);
                    } else { 
                        embed_type.html("");
                    } 

                    if(error.messages.perms) {
                        widget_options.html(error.messages.perms[0]);     
                        $.scrollTo('input[type="radio"][value="modal"]', 800);
                    } else { 
                        widget_options.html("");
                    } 
                } else { 
                    theme_name.html("");
                    site_id.html("");
                    embed_type.html("");
                    widget_options.html("");  

                    $("#widget-preview").show();
                    $("input[name=widgetkey]").val(responseText.widget.widgetkey);
                    var widget_key = $("input[name=widgetkey]").val();
                    var action = $("#preview-widget").attr('hrefaction') + "/" + widget_key;
                    $.ajax({
                        url: action
                        , type: "GET"
                        , dataType: 'json'
                        , success: function(data) {
                              $("#widget-generate-view").val(data.html_widget_js_code);
                              $("#iframe-generate-view").val(data.html_iframe_code);
                          } 
                    });

                    new ZClip();
                    new Status().notify("Success!", 1000);
                }   
          }
        }); 
        e.preventDefault(); 
    });

    //TODO: abstract this
    $("#create-form-widget").bind("submit", function(e) { 
        $(this).ajaxSubmit({
            dataType: 'json'       
          , beforeSubmit: function(formData, jqForm, options) {
                new Status().notify("Processing...", 1000); 
            }
          , success: function(responseText, statusText, xhr, $form) {

                $("input[name=widgetkey]").val(responseText.widget.widgetkey);

                $("#widget-preview").show();
                $("#widget-preview").siblings(".block").show();

                //console.log(responseText.widget.widgetkey);
                new Status().notify("Success!", 1000);

                var widget_key = $("input[name=widgetkey]").val();
                var action = $("#preview-widget").attr('hrefaction') + "/" + widget_key;
                $.ajax({
                    url: action
                    , type: "GET"
                    , dataType: 'json'
                    , success: function(data) {
                          //s36Lightbox(data.width, data.height, data.html_view);
                          $("#widget-generate-view").val(data.html_widget_js_code); 
                      } 
                });

                new ZClip();
                /*
                window.onbeforeunload = function() {
                    return "Are you sure you want to navigate away from this page?";
                };
                */
            }
        });
        e.preventDefault();
    });

    $(document).delegate("div#preview.button-gray", "click", function(e) {
        //start making fake forms! 
        $.ajax({
              url: $(this).attr('hrefaction')
            , data: {form_text: $("input[name=form_text]").val(), form_question: $("input[name=form_question]").val()}
            , dataType: 'json'
            , success: function(data) { 
                  s36Lightbox(data.width, data.height, data.html_view);
              } 
        });

        e.preventDefault(); 
    })
    
    $(document).delegate("a#preview-widget-btn", "click", function(e) {
        var widget_key = $("input[name=widgetkey]").val();
        var action = $("#preview-widget").attr('hrefaction') + "/" + widget_key;
        $.ajax({
            url: action
            , type: "GET"
            , dataType: 'json'
            , success: function(data) {
                  s36Lightbox(data.width, data.height, data.html_view); 
              } 
        });

        e.preventDefault();
    })

    //helper functions ABSTRACT THIS MOTHAFUCKER 
    function s36Lightbox(width, height, insertContent) {	
        if($('#lightbox').size() == 0){
            var theLightbox = $('<div id="lightbox"></div>');
            var theShadow = $('<div id="lightbox-shadow"/>');
            $(theShadow).click(function(e){
                    closeLightbox();
            });
            $('body').append(theShadow);
            $('body').append(theLightbox);
        }
        $('#lightbox').empty();
        if(insertContent != null){
            //This is just a test
            $('#lightbox').append(insertContent + "<div id='lightbox-comment' style='color:#fff;position:absolute;top:-20px;right:10px;'>This is a preview only | <span style='cursor:pointer'>close</span></div>");
        }

        $('#lightbox-comment').click(function(e){
            closeLightbox();
        });

        //set negative margin for dynamic width
        var margin = Math.round(width / 2);

        // set the css and show the lightbox
        $('#lightbox').css('top', $(window).scrollTop() + 50 + 'px');
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

    $('#full_page_widget').hide();
    $('#embed_widget').hide();
    $('#modal_widget').hide();

    $('#full_page_type').click(function(){
            fullpage_up();
            $("#embed_widget tr td").children('select, input[type="text"]').val(0).end()
            .children('input[type="radio"]').attr('checked', null);                   

            $("#modal_widget tr td").children('select').val(0);
            });

    $('#embed_type').click(function(){
            embed_up();
            $("#full_page_widget tr td").children('select').val(0);
            $("#modal_widget tr td").children('select').val(0);
            });

    $('#modal_type').click(function(){
            modal_up();
            $("#full_page_widget tr td").children('select').val(0); 
            $("#embed_widget tr td").children('select, input[type="text"]').val(0).end()
            .children('input[type="radio"]').attr('checked', null);                   
            });

    if($('input[value="embedded"]').attr('checked')) {
        embed_up();
    }

    if($('input[value="modal"]').attr('checked')) {
        modal_up();
    }

    function fullpage_up() { 
        $('#full_page_widget').slideDown();
        $('#embed_widget').slideUp();
        $('#modal_widget').slideUp();        
    }

    function embed_up() {
        $('#full_page_widget').slideUp();
        $('#embed_widget').slideDown();
        $('#modal_widget').slideUp(); 
    }

    function modal_up() {
        $('#full_page_widget').slideUp();
        $('#embed_widget').slideUp();
        $('#modal_widget').slideDown(); 
    }
     
    $("#edit-widget-btn").on("click", function(e) {   
        $.scrollTo('.widget-options:first-child', 800);
        e.preventDefault();
    });

    var overview = $("#overview-target, #display-overview-target, #form-overview-target");

    /* TODO: New type validation unlock submit button when text fields have value
    $("input[type='submit']").attr("disabled", true).css({'opacity' : '0.5'});
    $("input[type='text']").keyup(function(){
        if ($(this).val().length != 0) {
            $("input[type='submit']").removeAttr("disabled")
                                     .css({'opacity': '1.0'});
        } else { 
            $("input[type='submit']").attr("disabled", true).css({'opacity' : '0.5'});
        }
    });
    */

    overview.delegate(".pagination a", "click", function(e) {
        var url = $(this).attr('href');
        var me = $(this);

        $.ajax({
            url: url 
          , dataType: 'json'
          , beforeSend: function(xhr) {
                var myStatus = new Status();
                myStatus.notify("Processing...", 1000);
            }
          , success : function(data) {
                me.parents('span').html(data.view);
            }
        });

        e.stopImmediatePropagation();
        e.preventDefault();
    });

    var $form_slide = $('.form-designs').cycle({
        fx:      'scrollHorz', 
        speed:    500, 
        timeout:  0 ,
        pause : 1,
        next:   '.form-design-next', 
        prev:   '.form-design-prev'    
    });
   
    var selected_form = $('#selected-form').val();   //get the selected form
    var current_form_slide = $('#'+selected_form).parent(); //get the parent of the selected form
    var form_index  = parseInt(current_form_slide.index()); //get the index of the parent container   
    $form_slide.cycle(form_index);        // cycle the form theme selection to the index number
    $('#'+selected_form).addClass('selected-form');   // add class to the selected form thumbnail
    
    var positions = ['r','l','br','bl','tr','tl'];
    var tabpos = '';  
   
    $tab_slide = [];
    for(pos = 0;pos <= positions.length;pos++){
     tabpos = positions[pos];
     $tab_slide[tabpos] = $('.'+tabpos+'-designs').cycle({
      fx:      'scrollHorz', 
      speed:    500, 
      timeout:  0 ,
      pause : 1,
      next:   '.'+tabpos+'-design-next', 
      prev:   '.'+tabpos+'-design-prev'    
      });
    }
   
    var selected_tab = $('#selected-tab').val();   // get the selected tab
    var current_tab_slide = $('#'+selected_tab).parent(); //show the parent of the selected tab
    var tab_index  = parseInt(current_tab_slide.index());  // get the index of the parent container
    var selected_pos = $('#tab-position').val();   // get the current value of the tab position dropdown box
   
    $tab_slide[selected_pos].cycle(tab_index);    // cycle the current tab design
    $('#tab-slider').children().each(function(){   // hide all the tab design positions
        $(this).hide();
    });
   
    $('.'+selected_pos+'-design-slide').show();    // show the selected tab design
    $('#'+selected_tab).addClass('selected-tab');   // add class to the selected tab thumbnail 


    $('#tab-position').change(function(){
        var slide = $(this).val();
        $('#tab-slider').children().each(function(){
            $(this).hide();
        });
        
        $('.'+slide+'-design-slide').show();
    });
     
    $('.form-design').selected_theme('selected-form');
    $('.tab-design').selected_theme('selected-tab');    

    $(document).delegate(".delete-widget", "click", function(e) {
        var href = $(this).attr('href');
        var parent_div = $(this).parents('div.widget-types');
        
        if(confirm("Are you sure you want to delete this widget?")) { 
            $.ajax({
                url: href   
              , success: function(data) {
                    console.log(data);
                    parent_div.fadeOut(500, function() {
                        $(this).remove();
                    });
                }
            });
        }

        e.preventDefault();
    })
});

$.fn.selected_theme = function(select_name) {
    $(this).on('click', function(e) { 
        var value = $(this).attr('id'); 
        $('.' + select_name).removeClass(select_name);
        $(this).addClass(select_name); 
        $('#' + select_name).val(value); 
        console.log(value);
    })
}

function isDefined(target, path) {
    if (typeof target != 'object' || target == null) {
        return false;
    }

    var parts = path.split('.');

    while(parts.length) {
        var branch = parts.shift();
        if (!(branch in target)) {
            return false;
        }

        target = target[branch];
    }

    return true;
}
