// requires Helpers.

// class that collects settings data and does the auto saving.
var SettingsAutoSaver = new function(){
    
    this.interval = 5000;
    this.hosted_settings = '';
    this.def_data = {};
    this.panel_data = {};
    this.final_data = {};
    
    
    // initialize all the class needs.
    this.init = function(){
        
        // load the default data.
        this.hosted_settings = this.get_hosted_settings();
        this.def_data = $.parseJSON(this.hosted_settings);
        this.panel_data = $.parseJSON(this.hosted_settings);
        
        
        // start the autosave.
        setInterval('SettingsAutoSaver.save()', this.interval);
        
        // display section events.
        $('.tickerbox').click(function(){
            // i'm on the right track, baby i was born this way!
            var value = (  $(this).is('.off') ? '0' : '1' );
            SettingsAutoSaver.set_data($(this).attr('field'), value);
        });
        
        // description and colors section events.
        $('#panel_desc_textbox').blur(function(){
            SettingsAutoSaver.set_data('description', $(this).val());
        });
        
        $('.btnBgColor').on('change', function(){
            SettingsAutoSaver.set_data('button_bg_color', $(this).val());
        });
        
        $('.mbtnBgColor').on('change', function(){
            SettingsAutoSaver.set_data('button_hover_bg_color', $(this).val());
        });
        
        $('.btnFontColor').on('change', function(){
            SettingsAutoSaver.set_data('button_font_color', $(this).val());
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
            SettingsAutoSaver.set_data('theme_name', $('#selectedLayout').val());
        });
        
        // social media section events.
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
                    $('#fb_url_success_msg').fadeIn(200).css('display', 'inline-block');
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
                    $('#tw_url_success_msg').fadeIn(200).css('display', 'inline-block');
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
        Helpers.show_notification('Saving Page Display Changes', 0);
        
        // get the difference in def_data and panel_data then store it in final_data.
        $.each(this.panel_data, function(k, v){
            if( SettingsAutoSaver.def_data[k] != SettingsAutoSaver.panel_data[k] ){
                SettingsAutoSaver.final_data[k] = v;
                
                // also copy the different panel_data in def_data.
                SettingsAutoSaver.def_data[k] = v;
            }
        });
        
        var layoutChanged = false; //capture if layout was changed
        // save the final_data in db.
        $.ajax({
            async: false,
            url: '/update_panel_settings',
            type: 'post',
            //dataType: 'json',
            data: SettingsAutoSaver.final_data,
            success: function(result){
                if( $.trim(result) == 'You should be logged in to do this action' ){
                    Helpers.hide_notification();
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
        // $.get('get_fullpage_css', function(result){
        //     $('#fullpage_css').html(result);
        // });
        
        // hide notif.
        setTimeout('Helpers.hide_notification()', 1000);
        if(layoutChanged==true){
            window.location.hash    = "#3";
            window.location.href    = window.location.pathname+'?nocache&'+window.location.hash;
        }
        
    }
}