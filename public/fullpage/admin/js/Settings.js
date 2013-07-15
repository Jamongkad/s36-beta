// requires Helpers.

var Settings = new function(){
    
    var self = this;
    
    
    // initialize all the events of settings.
    this.init = function(){
        
        /* ========================================
        || Display option tickerbox active state toggler
        ==========================================*/
        $('.tickerbox').click(function(){
            var classes = $(this).attr('display-array');
            self.hide_element(classes, $(this).is('.off'));
            $(this).toggleClass('off');
        });

       
        /* ========================================
        || Background and Patterns
        ==========================================*/
        $('#selectedBackground').change(function(){
            var bg          = $(this).val();
            var bg_pos      = '';
            var bg_repeat   = '';

            SettingsAutoSaver.set_data('active_background', bg);
            if(bg == "pattern"){

                bg_pos      = 'left';
                bg_repeat   = 'repeat';

                self.apply_pattern_design($('#background_pattern').val());
                $('#backgroundImageOptions').hide();
                $('#backgroundPatternOptions').fadeIn('fast');
            }
            if(bg == 'image'){

                image_path  = $('#background_image').val();
                bg_pos      = $('.bgPos.active').attr('val');
                bg_repeat   = $('.bgRepeat.active').attr('val');
                
                self.change_background_image(image_path);
                $('#backgroundImageOptions').fadeIn();
                $('#backgroundPatternOptions').hide();
                $('#currentBgImagebackground_image').attr('src',image_path);
                
                if(image_path==''){
                    $('#blankBgImage').show();
                    $('#currentBg').hide();
                }
                else{
                    $('#blankBgImage').hide();
                    $('#currentBg').show();
                }
            }

            SettingsAutoSaver.set_data('page_bg_position',bg_pos);
            SettingsAutoSaver.set_data('page_bg_repeat',bg_repeat);

            self.change_background_position(bg_pos);
            self.change_background_repeat(bg_repeat);
        });

        $('.patternItem').click(function(){
            $('#background_pattern').val($(this).attr('id'));
            SettingsAutoSaver.set_data('background_pattern', $(this).attr('id'));
            SettingsAutoSaver.set_data('page_bg_position', 'left');
            SettingsAutoSaver.set_data('page_bg_repeat', 'repeat');
        });
        
        $('.backgroundColorPicker').on('change', function(){
            SettingsAutoSaver.set_data('page_bg_color', $(this).val());
            SettingsAutoSaver.set_data('page_bg_color_opacity', $(this).attr('data-opacity'));
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
                    Helpers.display_error_mes(error);
                    return false;
                }
                if( data.files[0].size > 2000000 ){
                    var error = ['Please upload an image that is less than 2mb'];
                    Helpers.display_error_mes(error);
                    return false;
                }
                data.submit();
            },progress: function(e, data){
                self.show_notification('Uploading Background Image',0);
            },done: function(e, data){
                self.change_background_image(data.result[0].url);
                self.hide_notification();
                SettingsAutoSaver.set_data('background_image', data.result[0].name);
                $('.patternItem').removeClass('active');  // so we can distinguish the type of our bg.
                $('#currentBgImage').attr('src',data.result[0].url);
                $('#blankBgImage').hide();
                $('#currentBg').show();
            }
        });

        /* ========================================
        || Apply the jcarousel plugin for the patterns
        ==========================================*/        
        /*
        $('#patterns').jcarousel({
            scroll: 5,
            initCallback: function(){},
            buttonNextHTML: '#patternPrev',
            buttonPrevHTML: '#patternNext',
            itemFallbackDimension: 300
        });
        */
        /* ========================================
        || Change this pattern's active state when a pattern is clicked
        ==========================================*/        
        $('.patternItem').click(function(){
            $('.patternItem.active').removeClass('active');
            $(this).addClass('active');
            self.apply_pattern_design($(this).attr('id'));
            SettingsAutoSaver.set_data('background_pattern', $(this).attr('id'));
            SettingsAutoSaver.set_data('page_bg_position', 'left');
            SettingsAutoSaver.set_data('page_bg_repeat', 'repeat');
            $('#currentBg').hide();
            $('#blankBgImage').show();
        });
        /* ========================================
        || Change the background color
        ==========================================*/
        $('.backgroundColorPicker').on('change',function(){
            self.change_background_color($(this).val(),$(this).attr('data-opacity'));
        });

        /* ========================================
        || Background position toggler
        ==========================================*/
        $('.bgPos').click(function(){
            $('.bgPos.active').removeClass('active');
            SettingsAutoSaver.set_data('page_bg_position', $(this).attr('val'));
            $(this).addClass('active');
        });
        /* ========================================
        || Background repeat toggler
        ==========================================*/
        $('.bgRepeat').click(function(){
            $('.bgRepeat.active').removeClass('active');
            SettingsAutoSaver.set_data('page_bg_repeat', $(this).attr('val'));
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
    || Layout Settings
    ==========================================*/
    //self.fancybox_layout();
    $('.layout-list li').click(function(){
        $('.layout-list li').each(function(){
            $(this).removeClass('selected');
        });
        $(this).addClass('selected');
        $('#selectedLayout').val(this.id);
        $('#layout-message').fadeOut();
    });
    $('#chooseLayout').click(function(){
        self.change_fullpage_layout($('#selectedLayout').val());
        //SettingsAutoSaver.set_data('theme_name', $('#selectedLayout').val());
    });

    $('.layout-item').click(function(){
        $('#previewLayout').attr('href',$(this).parent().find('.preview-layout-img').val());
        $('#previewLayout').attr('title',$(this).parent().find('.preview-layout-name').val()+' Layout Preview');
        //self.fancybox_layout();
    });

    /* ========================================
    || Other Settings
    ==========================================*/

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
    });

    $('.social_url').blur(function(){
        
        var url = $(this).val();
        var fb_regex = /^(https?:\/\/)?(www\.)?facebook\.com\/[\w\.-]+\/?$/;
        var tw_regex = /^(https?:\/\/)?(www\.)?twitter\.com\/(#!\/)?@?[\w\.-]+\/?$/;
        
        $(this).parent().find('.social_url_msg').hide();
        
        if( $(this).is('#fb_url') && url != SettingsAutoSaver.def_data.facebook_url ){
            if( url == '' ){
                SettingsAutoSaver.set_data('facebook_url', url);
                $('.social-icon.fb a').attr('href', '');
                $('.social-icon.fb').hide();
            }else if( url.match(fb_regex) != null ){
                SettingsAutoSaver.set_data('facebook_url', url);
                $('.social-icon.fb a').attr('href', url);
                $('.social-icon.fb').show();
                //$('#fb_url_success_msg').fadeIn(200).css('display', 'inline-block');
            }else if( url.match(fb_regex) == null ){
                $('#fb_url_error_msg').fadeIn(200).css('display', 'inline-block');
            }
        }
        
        if( $(this).is('#tw_url') && url != SettingsAutoSaver.def_data.twitter_url ){
            if( url == '' ){
                SettingsAutoSaver.set_data('twitter_url', url);
                $('.social-icon.tw a').attr('href', '');
                $('.social-icon.tw').hide();
            }else if( url.match(tw_regex) != null ){
                SettingsAutoSaver.set_data('twitter_url', url);
                $('.social-icon.tw a').attr('href', url);
                $('.social-icon.tw').show();
                //$('#tw_url_success_msg').fadeIn(200).css('display', 'inline-block');
            }else if( url.match(tw_regex) == null ){
                $('#tw_url_error_msg').fadeIn(200).css('display', 'inline-block');
            }
        }
        
    });
    }
     /* ========================================
    || Pattern change function
    ==========================================*/
    this.apply_pattern_design = function(filename){
        $('#body_image_overlay').hide();
        $('body').css('background-image','url(/fullpage/common/img/patterns/'+filename+')');
    }
    /* ========================================
    || Background Image Changer, supply the path
    ==========================================*/
    this.change_background_image = function(path){
        $('body').removeAttr('style');
        $('#body_image_overlay').show();
        $('#body_image_overlay').css('background-image','url('+path+')');
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
    || Background Color and Opacity Changer
    ==========================================*/
    this.change_background_color = function(hex,opc){
        var elem = $('#bodyColorOverlay');
        elem.css({'background-color':hex,'opacity':opc});
    }
    
    /* ========================================
    || Display an awesome notification, mes = messages in array, delay = integer in millisecond
    ==========================================*/
    this.show_notification = function(mes,delay){
        var delay = delay;
        $('#notification-message').empty().html(mes);
        $('#notification').animate({ height: '50', opacity: '100' }, 'fast','',function(){
            if(delay){
                setTimeout(self.hide_notification,delay);       
            }
        });
    }
    /* ========================================
    || Change Fullpage Layout
    ==========================================*/
    this.change_fullpage_layout = function(selected_layout){
        //self.show_notification('Updating layout settings', 3000);
        $.ajax({
            async: false,
            url: '/update_panel_settings',
            type: 'post',
            data: {theme_name:selected_layout},
            success: function(result){
                result = $.parseJSON(result);
                $('#layout-message').fadeIn();
            }
        });
    }
    /* ========================================
    || FancyBox for layout preview
    ==========================================*/
    this.fancybox_layout = function(){
        $('#previewLayout').fancybox({
             autoScale:true
            ,title: $('#previewLayout').attr('title')
            ,showCloseButton: true
            ,height:100
            ,width:100
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
            
            //if element is .last_name_ini, display of .last_name should be the opposite of this.
            if( obj.is('.last_name_ini') ){
                if( obj.css('display') == 'none' ) $('.last_name').css('display', 'inline-block');
                else $('.last_name').css('display', 'none');
            }
        });
        
    }
    
}