// JavaScript Document

/*=========================================
||
|| JS File for the Admin View
|| Date: 01/03/2013
|| Version: 0.0.0.1 
|| 
||=========================================*/
var S36FullpageAdmin = function(layoutObj){
    /* ========================================
    || Function needed to run by document ready
    ==========================================*/
    var self = this;
    var common = new S36FullpageCommon;
    this.patterns = ['45degreee_fabric.png', '60degree_gray.png', 'always_grey.png', 'batthern.png', 'beige_paper.png'];
    
    this.init_fullpage_admin = function(){
        
        // initialize the the PanelAutoSaver.
        // layoutObj is used as param because we use S36FullpageAdmin.show_notification() 
        // inside PanelAutoSaver.
        PanelAutoSaver.init(layoutObj);
        
        /* ========================================
        || Add a custom scrollbar on the quickinbox container
        ==========================================*/
        //$('.widget-list').jScrollPane();
        
        // editing of panel description.
        $('#panel_desc_container').jScrollPane();
        $('.companyDescription').click(function(){
            $('#desc_hint').hide();
            $('#panel_desc_container').hide();
            $('#panel_desc_textbox').show().focus();
            $('#panel_desc_textbox').val( Helpers.entities2html( Helpers.br2nl($(this).html().replace(/\n/g,'')) ) );
        });
        
        $('#panel_desc_textbox').blur(function(){
            $(this).hide();
            if( $.trim($(this).val()) == '' ) $('#desc_hint').show();
            $('#panel_desc_container').fadeIn();
            $('.companyDescription').html( Helpers.nl2br( Helpers.html2entities($(this).val()) ) );
            $('#panel_desc_container').jScrollPane();
            $('#fullpage_desc').html( Helpers.nl2br( Helpers.html2entities($(this).val()) ) );
        });
        
        // open the admin window
        $('.barLinks #admin_panel').click(function(e){
            $('#adminWindowBox').fadeIn('fast');
            var fullpageCommon = new S36FullpageCommon;
            fullpageCommon.init_quick_inbox();
            e.preventDefault();
        });
        
        /* ========================================
        || Make the admin window box draggable
        ==========================================*/
        $('#adminWindowBox').draggable({ handle: '#adminWindowTitleBar',opacity:0.5 });
        /* ========================================
        || Close the admin window box when close button is clicked
        ==========================================*/

        $('#adminWindowTitleBar .closeBtn').click(function(){
            $('#adminWindowBox').fadeOut('fast');
        });

        /* ========================================
        || Minimize the admin window when minimize button is clicked
        ==========================================*/
        var minClick = 1;
        $('#adminWindowTitleBar .minBtn').click(function(){
            $('#adminWindowHolder').slideToggle('fast');
            if(minClick == 1){
                $(this).addClass('maxBtn');
                minClick = 0;
            }else{
                $(this).removeClass('maxBtn');
                minClick = 1;
            }
        });
        /* ========================================
        || Add Selected Class to the chosen layout *NEW
        ==========================================*/
        $('.layout-list li').click(function(){
            $('.layout-list li.selected').removeClass('selected');   
            $(this).addClass('selected');
            $('#selectedLayout').val($(this).attr('id'));
        });
        /* ========================================
        || Change the background color
        ==========================================*/
        $('.backgroundColorPicker').on('change',function(){
            self.change_background_color($(this).val(),$(this).attr('data-opacity'));
        });
        /* ========================================
        || Change the button color
        ==========================================*/        
        $('.btnBgColor').on('change',function(){
            self.change_button_color($(this).val());
        });
        /* ========================================
        || Change the mouseover background color
        ==========================================*/        
        $('.mbtnBgColor').on('change',function(){
            self.change_mouseover_button_color($(this).val());
        });
        /* ========================================
        || Change the font of the mouse button color
        ==========================================*/        
        $('.btnFontColor').on('change',function(){
            self.change_button_font_color($(this).val());
        });
        /* ========================================
        || Apply the jcarousel plugin for the patterns
        ==========================================*/        
        $('#patterns').jcarousel({
            scroll: 5,
            initCallback: function(){},
            buttonNextHTML: '#patternPrev',
            buttonPrevHTML: '#patternNext'
        });
        /* ========================================
        || Change this pattern's active state when a pattern is clicked
        ==========================================*/        
        $('.patternItem').click(function(){
            $('.patternItem.active').removeClass('active');
            $(this).addClass('active');
            self.apply_pattern_design($(this).attr('id'));
            $('#currentBg').hide();
            $('#blankBgImage').show();
        });
        /* ========================================
        || Create pages for the admin window for each links
        ==========================================*/
        var $adminPage = $('#adminWindowPages').cycle({
            fx: 'fade', speed: 100, timeout: 0, before: self.adjust_window_height
        });
        /* ========================================
        || Change admin window screen when redirected with hash
        ==========================================*/
        var hash = window.location.hash;
        if(hash){
           var cur_window = parseInt(hash.substr(1));
           $adminPage.cycle(cur_window);
           $('#adminWindowMenuBar ul li a').removeClass('active');
           $('#adminWindowMenuBar ul li:eq('+cur_window+') a').addClass('active');
        }
        /* ========================================
        || Transition the current panel of the admin window when a tab is clicked
        ==========================================*/
        $('#adminWindowMenuBar ul li').click(function(){
            $('#adminWindowMenuBar ul li .active').removeClass('active');
            $(this).find('a').addClass('active');
            var index = $(this).index();
            $adminPage.cycle(index);
        });

        /* ========================================
        || Apply the fileupload plugin for the background image
        ==========================================*/
        $('#bg_image').fileupload({
            dropZone: '#bgDragBox',
            dataType: 'json',
            add: function(e, data){
                var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
                if( image_types.indexOf( data.files[0].type ) == -1 ){
                    var error = ['Please select an image file'];
                    self.display_error_mes(error);
                    return false;
                }
                if( data.files[0].size > 2000000 ){
                    var error = ['Please upload an image that is less than 2mb'];
                    self.display_error_mes(error);
                    return false;
                }
                data.submit();
            },progress: function(e, data){
                self.show_notification('Uploading Background Image',0);
            },done: function(e, data){
                self.change_background_image(data.result[0].url);
                self.hide_notification();
                PanelAutoSaver.set_data('background_image', data.result[0].name);
                $('.patternItem').removeClass('active');  // so we can distinguish the type of our bg.
                $('#currentBgImage').attr('src',data.result[0].url);
                $('#background_image').val(data.result[0].url);
                $('#blankBgImage').hide();
                $('#currentBg').show();
            }
        });
        
        /* ========================================
        || Display option tickerbox active state toggler
        ==========================================*/
        $('.tickerbox').click(function(){
            var classes = $(this).attr('display-array');
            self.hide_element(classes, $(this).is('.off'));
            $(this).toggleClass('off');
        });
        /* ========================================
        || Background image or pattern toggler
        ==========================================*/
        $('#selectedBackground').change(function(){
            var bg = $(this).val();
            if(bg == "pattern"){
                image_path = 'fullpage/common/img/patterns/'+$('#background_pattern').val();
                $('#backgroundImageOptions').hide();
                $('#backgroundPatternOptions').fadeIn('fast');
                $('#adminWindowPages').animate({height:'235'});
                //$('body').css('background-image','url('+image_path+')');
                $('#body_image_overlay').css('background-image','url('+image_path+')');

                self.change_background_position('left');
                self.change_background_repeat('repeat');
                PanelAutoSaver.set_data('page_bg_position', 'left');
                PanelAutoSaver.set_data('page_bg_repeat', 'repeat');
            }else{
                image_path = $('#background_image').val();
                active_pos = $('.bgPos.active').attr('val');
                active_rep = $('.bgRepeat.active').attr('val');
                $('#backgroundImageOptions').fadeIn();
                $('#backgroundPatternOptions').hide();
                $('#adminWindowPages').animate({height:'496'});
                //$('body').css('background-image','url('+image_path+')');
                $('#body_image_overlay').css('background-image','url('+image_path+')');
                $('#currentBgImage').attr('src',image_path);
                if(image_path==''){
                    $('#blankBgImage').show();
                    $('#currentBg').hide();
                }
                else{
                    $('#blankBgImage').hide();
                    $('#currentBg').show();
                }

                self.change_background_position(active_pos);
                self.change_background_repeat(active_rep);
                PanelAutoSaver.set_data('page_bg_position',active_pos);
                PanelAutoSaver.set_data('page_bg_repeat',active_rep);
            }
            PanelAutoSaver.set_data('active_background', bg);
        });
        /* ========================================
        || Background position toggler
        ==========================================*/
        $('.bgPos').click(function(){
            $('.bgPos.active').removeClass('active');
            $(this).addClass('active');
        });
        /* ========================================
        || Background repeat toggler
        ==========================================*/
        $('.bgRepeat').click(function(){
            $('.bgRepeat.active').removeClass('active');
            $(this).addClass('active');
        });
        /* ========================================
        || Background position change to left
        ==========================================*/
        $('#bg_pos_l').click(function(){
            self.change_background_position('left');
        });
        /* ========================================
        || Background position change to center
        ==========================================*/
        $('#bg_pos_c').click(function(){
            self.change_background_position('center');
        });
        /* ========================================
        || Background position change to right
        ==========================================*/
        $('#bg_pos_r').click(function(){
            self.change_background_position('right');
        });
        /* ========================================
        || Background position change to top
        ==========================================*/
        $('#bg_pos_t').click(function(){
            self.change_background_position('top');
        });
        /* ========================================
        || Background position change to bottom
        ==========================================*/
        $('#bg_pos_b').click(function(){
            self.change_background_position('bottom');
        });
        /* ========================================
        || Background repeat change to repeat
        ==========================================*/
        $('#bg_repeat_r').click(function(){
            self.change_background_repeat('repeat');
        });
        /* ========================================
        || Background repeat change to no-repeat
        ==========================================*/
        $('#bg_repeat_nr').click(function(){
            self.change_background_repeat('no-repeat');
        });
        /* ========================================
        || Background repeat change to repeat-x
        ==========================================*/
        $('#bg_repeat_rh').click(function(){
            self.change_background_repeat('repeat-x');
        });
        /* ========================================
        || Background repeat change to repeat-y
        ==========================================*/
        $('#bg_repeat_rv').click(function(){
            self.change_background_repeat('repeat-y');
        });
        /* ========================================
        || When the cover button is saved, use this function to update the database
        ==========================================*/
        $('#saveCoverButton').click(function(){
            self.upload_to_server('change');
            $('#saveCoverButton').html('Cover Saved');
            var timeout;
            if(timeout) {
                clearTimeout(timeout);
                timeout = null;
            }
            timeout = setTimeout(self.hide_save_button, 1000);
        });
    }
    
    
    
    /* ========================================
    || Pattern change function
    ==========================================*/
    this.apply_pattern_design = function(filename){
        $('body').css('background-image','url(fullpage/common/img/patterns/'+filename+')');
    }
    /* ========================================
    || Background Image Changer, supply the path
    ==========================================*/
    this.change_background_image = function(path){
        $('body').css('background-image','url('+path+')');
        $('#bodyColorOverlay').css('opacity',0);
    }
    
    /* ========================================
    || Background repeat attribute changer
    ==========================================*/
    this.change_background_repeat = function(rules){
        //$('body').css('background-repeat',rules);
        $('#body_image_overlay').css('background-repeat',rules);
    }
    /* ========================================
    || Background position attribute changer
    ==========================================*/
    this.change_background_position = function(pos){
        //$('body').css('background-position',pos);
        $('#body_image_overlay').css('background-position',pos);
    }
    /* ========================================
    || Button Font Color Changer
    ==========================================*/
    this.change_button_font_color = function(hex){
        var elem = $('.send-button a');
        elem.css({'color':hex});    
    }
    /* ========================================
    || Button Background Color Changer
    ==========================================*/
    this.change_button_color = function(hex){
        var elem = $('.send-button a');
        elem.css({'background-color':hex}); 
    }
    /* ========================================
    || Button Mouseover Bg color Changer. Trust me no other script will work other than this
    ==========================================*/
    this.change_mouseover_button_color = function(hex){
        var elem = $('.send-button a');
        elem.hover(function(){
            $(this).css({'background-color':hex});  
        },function(){
            var althex = $('.btnBgColor').val();
            $(this).css({'background-color':althex});   
        });
    }
    /* ========================================
    || Background Color and Opacity Changer
    ==========================================*/
    this.change_background_color = function(hex,opc){
        var elem = $('#bodyColorOverlay');
        elem.css({'background-color':hex,'opacity':opc});
    }
    /* ========================================
    || Adjust the admin window height depending on the elements inside
    ==========================================*/
    this.adjust_window_height = function(curr, next, opts, fwd) {
        var $ht = $(this).height();
        $(this).parent().animate({"height":$ht},'fast');
    }
    /* ========================================
    || Display an awesome notification, mes = messages in array, delay = integer in millisecond
    ==========================================*/
    this.show_notification = function(mes,delay){
        var delay = delay;
        $('#notification-message').empty().html(mes);
        $('#notification').animate({ height: '50', opacity: '100' }, 'fast','',function(){
            if(delay){
                setTimeout(this.hide_notification,delay);       
            }
        });
    }
    /* ========================================
    || Hide the Notification
    ==========================================*/
    this.hide_notification = function(){
        $("#notification").animate({ height: 0, opacity: 0 }, 'fast');
    }
    /* ========================================
    || Hide an element using its class
    ==========================================*/
    this.hide_element = function(elem, off){
        var classes = elem.split(',');
        
        $.each(classes, function(index, value){
            var obj = $('.' + value);
            
            // i'm on the right track, baby i was born this way.
            if( off ) obj.css('display', 'inline-block');
            else obj.css('display', 'none');
            
            // if element is .rating-stat, show only the none-zero votes.
            if( obj.is('.rating-stat') ){
                $('.rating-stat').each(function(){
                    if( $(this).find('.vote_count').text() == '0' ) $(this).css('display', 'none');
                });
            }
            
            // if element is .last_name_ini, display of .last_name should be the opposite of this.
            if( obj.is('.last_name_ini') ){
                if( obj.css('display') == 'none' ) $('.last_name').css('display', 'inline-block');
                else $('.last_name').css('display', 'none');
            }
        });
        
        common.reload_layout_masonry(layoutObj);
    }
    
    
    /* ========================================
    || Hide the save button when clicked
    ==========================================*/
    this.hide_save_button = function(){
        $('#saveCoverButton').fadeOut('fast',function(){
            $(this).html('Save Cover');
        });
        $('#changeCoverButton').fadeIn('fast');
        $('#dragPhoto').fadeOut('fast');
        self.make_cover_undraggable(true);
    }

}
// class that collects admin panel data and does the auto saving.
var PanelAutoSaver = new function(layoutObj){
    
    this.interval = 5000;
    this.hosted_settings = '';
    this.def_data = {};
    this.panel_data = {};
    this.final_data = {};
    this.S36FullpageAdmin = new S36FullpageAdmin(layoutObj);
    
    
    // initialize all the class needs.
    this.init = function(){
        
        // load the default data.
        this.hosted_settings = this.get_hosted_settings();
        this.def_data = $.parseJSON(this.hosted_settings);
        this.panel_data = $.parseJSON(this.hosted_settings);
        
        // start the autosave.
        setInterval('PanelAutoSaver.save()', this.interval);
        
        
        // background section events.
        $('#bg_image').change(function(){
            // PanelAutoSaver.set_data() of this element is in fileupload().
        });
        
        $('.bgPos').click(function(){
            PanelAutoSaver.set_data('page_bg_position', $(this).attr('val'));
        });
        
        $('.bgRepeat').click(function(){
            PanelAutoSaver.set_data('page_bg_repeat', $(this).attr('val'));
        });
        
        $('.patternItem').click(function(){
            $('#background_pattern').val($(this).attr('id'));
            PanelAutoSaver.set_data('background_pattern', $(this).attr('id'));
            PanelAutoSaver.set_data('page_bg_position', 'left');
            PanelAutoSaver.set_data('page_bg_repeat', 'repeat');
        });
        
        $('.backgroundColorPicker').on('change', function(){
            PanelAutoSaver.set_data('page_bg_color', $(this).val());
            PanelAutoSaver.set_data('page_bg_color_opacity', $(this).attr('data-opacity'));
        });
        
        // display section events.
        $('.tickerbox').click(function(){
            // i'm on the right track, baby i was born this way!
            var value = ( ! $(this).is('.off') ? '0' : '1' );
            PanelAutoSaver.set_data($(this).attr('field'), value);
        });
        
        // description and colors section events.
        $('#panel_desc_textbox').blur(function(){
            PanelAutoSaver.set_data('description', $(this).val());
        });
        
        $('.btnBgColor').on('change', function(){
            PanelAutoSaver.set_data('button_bg_color', $(this).val());
        });
        
        $('.mbtnBgColor').on('change', function(){
            PanelAutoSaver.set_data('button_hover_bg_color', $(this).val());
        });
        
        $('.btnFontColor').on('change', function(){
            PanelAutoSaver.set_data('button_font_color', $(this).val());
        });

        // layout section events
        $('.layout-list li').click(function(){
            $('.layout-list li').each(function(){
                $(this).removeClass('selected');
            });
            $(this).addClass('selected');
            $('#selectedLayout').val(this.id);
        });
        $('#chooseLayout').click(function(){
            $('#maskDisabler').fadeIn();
            PanelAutoSaver.set_data('theme_name', $('#selectedLayout').val());
        });
        
        // social media section events.
        $('.social_url').blur(function(){
            
            var url = $(this).val();
            var fb_regex = /^(https?:\/\/)?(www\.)?facebook\.com\/[\w\.-]+\/?$/;
            var tw_regex = /^(https?:\/\/)?(www\.)?twitter\.com\/(#!\/)?@?[\w\.-]+\/?$/;
            
            $(this).parent().find('.social_url_msg').hide();
            
            if( $(this).is('#fb_url') && url != PanelAutoSaver.def_data.facebook_url ){
                if( url == '' ){
                    PanelAutoSaver.set_data('facebook_url', url);
                    $('.social-icon.fb a').attr('href', '');
                    $('.social-icon.fb').hide();
                }else if( url.match(fb_regex) != null ){
                    PanelAutoSaver.set_data('facebook_url', url);
                    $('.social-icon.fb a').attr('href', url);
                    $('.social-icon.fb').show();
                    //$('#fb_url_success_msg').fadeIn(200).css('display', 'inline-block');
                }else if( url.match(fb_regex) == null ){
                    $('#fb_url_error_msg').fadeIn(200).css('display', 'inline-block');
                }
            }
            
            if( $(this).is('#tw_url') && url != PanelAutoSaver.def_data.twitter_url ){
                if( url == '' ){
                    PanelAutoSaver.set_data('twitter_url', url);
                    $('.social-icon.tw a').attr('href', '');
                    $('.social-icon.tw').hide();
                }else if( url.match(tw_regex) != null ){
                    PanelAutoSaver.set_data('twitter_url', url);
                    $('.social-icon.tw a').attr('href', url);
                    $('.social-icon.tw').show();
                    //$('#tw_url_success_msg').fadeIn(200).css('display', 'inline-block');
                }else if( url.match(tw_regex) == null ){
                    $('#tw_url_error_msg').fadeIn(200).css('display', 'inline-block');
                }
            }
            
        });
        
    }
    
    
    // get hosted settings form db.
    this.get_hosted_settings = function(){
        
        var data;
        
        $.ajax({
            async: false,
            url: '/get_panel_settings',
            success: function(result){
                data = result;
            }
        });
        
        return data;
        
    }
    
    
    // store the field and value.
    this.set_data = function(field, value){
        
        // the value always have to be a string.
        this.panel_data[field] = value.valueOf();
        
    }
    
    
    // save the collected data in admin panel.
    // this will run on the set interval.
    this.save = function(){
        
        // check if there are differences in def_data and panel_data.
        // if yes, store the difference in final_data. else, don't proceed.
        if( JSON.stringify(this.def_data) === JSON.stringify(this.panel_data) ) return;
        
        // show notif.
        this.S36FullpageAdmin.show_notification('Saving Panel Changes', 0);
        
        // get the difference in def_data and panel_data then store it in final_data.
        $.each(this.panel_data, function(k, v){
            if( PanelAutoSaver.def_data[k] != PanelAutoSaver.panel_data[k] ){
                PanelAutoSaver.final_data[k] = v;
                
                // also copy the different panel_data in def_data.
                PanelAutoSaver.def_data[k] = v;
            }
        });
        
        var layoutChanged = false; //capture if layout was changed
        // save the final_data in db.
        $.ajax({
            async: false,
            url: '/update_panel_settings',
            type: 'post',
            //dataType: 'json',
            data: PanelAutoSaver.final_data,
            success: function(result){
                if( $.trim(result) == 'You should be logged in to do this action' ){
                    PanelAutoSaver.S36FullpageAdmin.hide_notification();
                    Helpers.display_error_mes( [result] );
                }
                
                result = $.parseJSON(result);
                if(undefined != result.theme_name){
                    layoutChanged = true;
                }
            }
        });
        
        // clear the final_data.
        this.final_data = {};
        
        // update fullpage css.
        $.get('get_fullpage_css', function(result){
            $('#fullpage_css').html(result);
        });
        
        // hide notif.
        setTimeout('PanelAutoSaver.S36FullpageAdmin.hide_notification()', 1000);
        if(layoutChanged==true){
            window.location.hash    = "#3";
            window.location.href    = window.location.pathname+'?nocache&'+window.location.hash;
        }
    }
}
