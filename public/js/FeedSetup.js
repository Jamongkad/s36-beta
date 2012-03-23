jQuery(function($) {
    /*
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
    var preview_widget = ".preview-display-widget-button, .preview-form-widget-button";
    $(preview_widget).attr("disabled", true).css({'opacity' : '0.5'});
    $(document).delegate("#create-widget", "submit", function(e) {
      
        if ($("input[name=theme_name]", this).val() == "Name of your widget" ) { 
            alert("Please choose a name for your widget");
        } else if ( !$('input[value="embedded"]').attr('checked') && !$('input[value="modal"]').attr('checked') ) {
            alert("Please choose a widget type");
        } else {
            
            $(this).ajaxSubmit({
                dataType: 'json'
              , beforeSubmit: function(formData, jqForm, options) {
                    new Status().notify("Processing...", 1000); 
                }
              , success: function(responseText, statusText, xhr, $form) {  
                   
                    $("#widget-preview").show();
                    $("input[name=display_widgetkey]").val(responseText.display.widget.widgetkey);
                    $("input[name=submit_widgetkey]").val(responseText.submit.widget.widgetkey);
                    var widget_key = $("input[name=display_widgetkey]").val();

                    var action = $("#preview-widget").attr('hrefaction') + "/" + widget_key;
                    $.ajax({
                          url: action
                        , type: "GET"
                        , dataType: 'json'
                        , success: function(data) {
                              $("#widget-generate-view").val(data.html_widget_js_code);
                              $("#iframe-generate-view").val(data.html_iframe_code);
                              new ZClip();
                          } 
                    });


                    new Status().notify("Success!", 1000);

                    $(preview_widget).removeAttr("disabled").css({'opacity': '1.0'});
                    $(document).delegate('.preview-display-widget-button', 'click', function(e) {  

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
              }
            }); 
        }
        e.preventDefault(); 
    });

    //TODO: abstract this
    $(document).delegate("#create-form-widget", "submit", function(e) {
        $(this).ajaxSubmit({
            dataType: 'json'       
          , beforeSubmit: function(formData, jqForm, options) {
                new Status().notify("Processing...", 1000); 
            }
          , success: function(responseText, statusText, xhr, $form) {

                var widget_key = responseText.submit.widget.widgetkey;
                var formcode_url = $("#formcode-manager-url").attr('hrefaction') + widget_key;
                $("input[name=submit_widgetkey]").val(widget_key);
                $("#widget-preview").show();
                new Status().notify("Success!", 1000);
                var action = $("#preview-widget").attr('hrefaction') + "/" + widget_key;
                $.ajax({
                    url: action
                    , type: "GET"
                    , dataType: 'json'
                    , success: function(data) {
                          console.log(formcode_url);
                          //window.location = formcode_url + "/" + widget_key;
                      } 
                });
                $(preview_widget).removeAttr("disabled").css({'opacity': '1.0'});
                /*
                window.onbeforeunload = function() {
                    return "Are you sure you want to navigate away from this page?";
                };
                */
            }
        });
        e.preventDefault();    
    });
 
    //preview picked out of form theme slider and other preview buttons
    $(document).delegate(".preview-form-widget-button, div#preview.button-gray", "click", function(e) {
        var action = $("#preview-form-widget-url").attr("hrefaction");
        var form_theme = $("#selected-form").val();
        var action_url = action + "/"  + form_theme;
    
        $.ajax({
              url: action_url 
            , data: {submit_form_text: $("input[name=submit_form_text]").val(), submit_form_question: $("textarea[name=submit_form_question]").val()}
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
    
    $form_slide.cycle(expose_index('#selected-form'));  // cycle the form theme selection to the index number
 
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

    var tab_index = expose_index('#selected-tab');

    $form_slide.cycle(expose_index('#selected-form'));  // cycle the form theme selection to the index number
    var selected_pos = $('#tab-position').val();   // get the current value of the tab position dropdown box
  
    $tab_slide[selected_pos].cycle(tab_index);    // cycle the current tab design
    $('#tab-slider').children().each(function(){   // hide all the tab design positions
        $(this).hide();
    });
   
 
    $('.'+selected_pos+'-design-slide').show();    // show the selected tab design  

    $('#tab-position').change(function(){
        var slide = $(this).val();
        $('#tab-slider').children().each(function(){
            $(this).hide();
        });
        
        $('.'+slide+'-design-slide').show();
    });
     
    $('.form-design').selected_theme({set_value: '#selected-form'});
    $('.tab-design').selected_theme({set_value: '#selected-tab'});    

    $(document).delegate(".delete-widget", "click", function(e) {
        var href = $(this).attr('href');
        var parent_div = $(this).parents('div.widget-types');
        
        if(confirm("Are you sure you want to delete this widget?")) { 
            $.ajax({
                url: href   
              , success: function(data) {
                    parent_div.fadeOut(500, function() { $(this).remove(); });
                }
            });
        }

        e.preventDefault();
    })
    
    $(".large-text, .regular-text").focus(function(i){          		 
        if ($(this).val() == $(this)[0].title){
            $(this).removeClass("reg-text-active");
            $(this).val("");
        }
    });

    $(".large-text, .regular-text").blur(function(){
        if ($.trim($(this).val()) == ""){
            $(this).val($(this)[0].title);
        }
    });
    $(".large-textarea, .regular-textarea, .form-text, .large-text").each(function() {
        $(this).val($(this)[0].title);
    });

});

$.fn.selected_theme = function(select_name) {
    $(this).on('click', function(e) { 
        var value = $(this).attr('id'); 

        var deselect_this = false;

        $(this).siblings().each(function() {
            $(this).removeClass("selected-theme");     
        });

        if(!deselect_this) {
            $(this).addClass("selected-theme");
        }
       
        $(select_name.set_value).val(value);
    })
}

function expose_index(selector) {
    var selected = $(selector).val();   //get the selected form
    var current_slide = $('#'+selected).parent(); //get the parent of the selected form
    var index  = parseInt(current_slide.index()); //get the index of the parent container   

    $('#'+selected).addClass('selected-theme');   // add class to the selected form thumbnail
    return index; 
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
