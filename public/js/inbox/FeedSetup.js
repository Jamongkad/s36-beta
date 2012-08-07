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

    return this;
}

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

    window.onbeforeunload = function() {
        return "Are you sure you want to navigate away from this page?";
    };
    */

    var preview_widget = ".preview-display-widget-button, .preview-form-widget-button";
    $(preview_widget).attr("disabled", true).css({'opacity' : '0.5'});
    $(document).delegate("#create-widget", "submit", function(e) {
      
        var form_header_text = $('#form-header-text');
        var form_what_to_write =  $('#form-what-to-write');
        if (!validate_field(form_header_text.val(), true, "regular")) { 
            form_header_text.focus();
        } else if (!validate_field(form_what_to_write.val(), true, "regular")) {
            form_what_to_write.focus();
        } else {

            $(this).ajaxSubmit({
                dataType: 'json'
              , beforeSubmit: function(formData, jqForm, options) {
                    new Status().notify("Processing...", 1000); 
                }
              , success: function(responseText, statusText, xhr, $form) {   
                    var widget_key = responseText.display.widget.widgetkey;
                    var formcode_url = $("#formcode-manager-url").attr('hrefaction') + "/" + widget_key;
                    window.location = formcode_url;
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
                var formcode_url = $("#formcode-manager-url").attr('hrefaction') + "/" + widget_key;
                window.location = formcode_url;
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
        $('input[name="widget_select"]').val('embed');
    });

    $('#modal_type').click(function(){
        modal_up();
        $("#full_page_widget tr td").children('select').val(0); 
        $("#embed_widget tr td").children('select, input[type="text"]').val(0).end()
        .children('input[type="radio"]').attr('checked', null);                   
        $('input[name="widget_select"]').val('modal');
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
    $('.tab-design').selected_theme({set_value: '#selected-tab'}).click(function(e) { 
        var value = $(this).attr('id'); 
        var widgetkey = $('input[name=submit_widgetkey]').val();
        var url = $('#update-tabtype-url').attr('hrefaction') + '/' + widgetkey + '/' + value;

        $.ajax({
            url: url     
          , beforeSend: function() { 
                new Status().notify("Processing...", 1000); 
            }
          , success: function(msg) { 
                new Status().notify("Success!", 1000); 
            }
        })
        e.preventDefault();
    });    

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

    $('.display-option').click(function(){
        run_display_option();
    });
    /* added for wizard page */
    var $wizard_slide = $('#wizard').cycle({
        fx:      'fade', 
        speed:    200, 
        timeout:  0 ,
        pause : 1,
        before: adjust_height
    });
    /* end */ 
    check_current_wizard_step(); 
    $('#wizard-back').hide();    
    $('#wizard-next').click(function(e){
        cur_step = check_current_wizard_step();
        if(cur_step == 'wizard-step-1'){
            var form_name = $('#form-name');
            if(!validate_field(form_name.val(), true, "regular")){
                form_name.focus();
            }else{
                $wizard_slide.cycle('next');
                $('#wizard-back').fadeIn();
            }
        }else if(cur_step == 'wizard-step-2'){
            var header_text = $('#header-text');
            if(!validate_field(header_text.val(), true, "regular")){
                header_text.focus();
            }else{
                $wizard_slide.cycle('next');
            }
        } else if(cur_step == 'wizard-step-3') {
            var embed_radio = $('input[type=radio]');
            if(embed_radio.length > 0 && embed_radio.is(':checked') || $('input[name=embed_type]').val() == 'modal') {
                $wizard_slide.cycle('next');     
            } else {
                return e.preventDefault();     
            }
            
        } else if(cur_step == 'wizard-step-4') {
            $('.create-widget-button').fadeIn('fast');
            $('#wizard-next').fadeOut('fast');
            $wizard_slide.cycle('next');
        }   
    });
    
    $('#wizard-back').click(function(){
        cur_step = check_current_wizard_step();
        if(cur_step == 'wizard-step-2'){
            $(this).fadeOut();
        } else {
            $('#wizard-next').fadeIn('fast');     
            $('.create-widget-button').hide(); 
        }

        $wizard_slide.cycle('prev');
    });
    
    $('.form-design').click(function(){
        var value = $(this).attr('id');
        $('.selected-form').removeClass('selected-form');
        $(this).addClass('selected-form');
        $('#selected-form').val(value);
    });
        
    $('#theme-select').change(function(){
        var theme = $(this).val();
        $('.form-design-slide').hide();
        $('#'+theme).fadeIn();
    });

    //this little guy will show set the children based on a styles parent
    var my_parent = $('#theme-select option:selected').val();
    if(my_parent) {
        $('.form-design-slide').hide();
        $('#'+my_parent).fadeIn();     
    }
});

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

function check_current_wizard_step(){
    var cur_step = $('#wizard').find('.current').attr('id');
    return cur_step;
}

function adjust_height(curr, next, opts, fwd) {		
    var index = opts.currSlide;
    var $ht = $(this).height();
    $(this).parent().animate({height: $ht},200);				
    $(this).parent().find('div.current').removeClass('current'); 
    $(this).addClass('current');
}

function run_display_option(){
    var display_id = '';
    $('.display-option').each(function(){
        display_id = $(this).attr('id');
        container_id = "#wizard-"+display_id;
        if($(this).attr('checked')){							
            if($(this).attr('id') == 'preview-avatar'){
                $('img#avatar-display').fadeIn();
                $('img#avatar-blank').hide();
            }else if($(this).attr('id') == 'preview-website'){
                $(container_id).css('text-decoration','underline');
            }else{
                $(container_id).fadeIn('fast');
            }
        }else{
            
            if($(this).attr('id') == 'preview-avatar'){
                $('img#avatar-display').hide();
                $('img#avatar-blank').fadeIn();
            }else if($(this).attr('id') == 'preview-website'){
                $(container_id).css('text-decoration','none');
            }else{
                $(container_id).fadeOut('fast');
            }						
        }
    });
}
function validate_field(value, default_val, type){
    if(type == "regular"){   // check if type is only regular
        if((value.length <= 0) || (value == default_val)){		
            return false;
        }else{
            return true;
        }
    }else if(type == "email"){ //if type is email
        if((value.length <= 0) || (value == default_val)){
            return false;
        }else if(!validate_email(value)){
            return false;	
        }else{
            return true;
        }
    }else if(type == "phone"){
        //phone only allows '+',','," " and numeric values 
        var phone = new RegExp('[+0-9 ,]');
        var notallow = new RegExp('[a-zA-Z]');
        if((!value.match(phone)) || (value.match(notallow))){
            return false;
        }else{
            return true;
        }
    }else if(type == "numeric"){
        //strictly allows numeric values only
        var numeric = new RegExp('[0-9 ]');
        var notallow = new RegExp('[a-zA-Z]');
        if((!value.match(numeric)) || (value.match(notallow))){
            return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
}
function validate_email(email) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        return true;
    }else{
        return false;
    }
}
