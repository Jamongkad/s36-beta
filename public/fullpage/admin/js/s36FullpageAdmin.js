// class that collects admin panel data and does the auto saving.
var PanelAutoSaver = new function(){
    
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
        setInterval('PanelAutoSaver.save()', this.interval);
        
        /*
        // background section events.
        $('#bg_image').change(function(){  // is there a change event for file input?
            PanelAutoSaver.set_data('background_image', $('body').css('background-image'));
        });
        
        $('.bgPos').click(function(){
            PanelAutoSaver.set_data('page_bg_position', $('body').css('background-position'));
        });
        
        $('.bgRepeat').click(function(){
            PanelAutoSaver.set_data('page_bg_repeat', $('body').css('background-repeat'));
        });
        
        $('.patternItem').click(function(){
            PanelAutoSaver.set_data('background_image', $(this).attr('id'));
        });
        
        $('.backgroundColorPicker').on('change', function(){
            PanelAutoSaver.set_data('page_bg_color', $(this).val());
            PanelAutoSaver.set_data('page_bg_color_opacity', $(this).attr('data-opacity'));
        });
        
        // display section events.
        $('.tickerbox').click(function(){
            var value = ( $(this).is('.off') ? '0' : '1' );
            PanelAutoSaver.set_data($(this).attr('field'), value);
        });
        
        // description and colors section events.
        $('#desc_text').blur(function(){  // not yet the actual id.
            PanelAutoSaver.set_data('description', $(this).val());
        });
        
        $('#desc_font_size').change(function(){  // not yet the actual id.
            PanelAutoSaver.set_data('description_font_size', $(this).val());
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
        
        // social media section events.
        $('#save_links').click(function(){  // not yet the actual id.
            PanelAutoSaver.set_data('facebook_url', $('#facebook_url').val());  // not yet the actual id.
            PanelAutoSaver.set_data('twitter_url', $('#twitter_url').val());  // not yet the actual id.
        });
        */
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
        showNotification('Saving Changes', 1000);
        
        // get the difference in def_data and panel_data then store it in final_data.
        $.each(this.panel_data, function(k, v){
            if( PanelAutoSaver.def_data[k] != PanelAutoSaver.panel_data[k] ){
                PanelAutoSaver.final_data[k] = v;
                
                // also copy the different panel_data in def_data.
                PanelAutoSaver.def_data[k] = v;
            }
        });
        
        // save the final_data in db.
        $.ajax({
            async: false,
            url: '/update_panel_settings',
            type: 'post',
            data: PanelAutoSaver.final_data,
            success: function(result){
                if( $.trim(result) != '' ){
                    hideNotification();
                    Helpers.display_error_mes( [result] );
                }
            }
        });
        
        // clear the final_data.
        this.final_data = {};
        
    }
    
}


PanelAutoSaver.init();
/*
console.log(PanelAutoSaver.hosted_settings);
console.log(PanelAutoSaver.def_data);
console.log(PanelAutoSaver.panel_data);
console.log(PanelAutoSaver.final_data);
*/
/*
PanelAutoSaver.set_data('show_rating', '0');
PanelAutoSaver.set_data('show_votes', '0');
PanelAutoSaver.set_data('show_recommendation', '0');
PanelAutoSaver.save();
*/


/*
    $('.social_url').keydown(function(e){  // not yet the actual id.
        console.log(e);
        //console.log(e.keyCode);
        
        // for twitter.
        if( $(this).is('#twitter_url') ){  // not yet the actual id.
            if( (e.keyCode >= 49 && e.keyCode <= 51) && e.shiftKey ) return;  // 1-3 in alphanum keys while shift key is held
        }
        
        if( e.keyCode >= 65 && e.keyCode <= 90 ) return;  // a-z
        else if( (e.keyCode >= 48 && e.keyCode <= 57) && ! e.shiftKey ) return;  // 0-9 in alphanum keys and shift key is not held
        else if( e.keyCode >= 96 && e.keyCode <= 105 ) return;  // 0-9 in num keys
        else if( e.keyCode >= 8 && e.keyCode <= 9 ) return;  // backspace, tab
        else if( e.keyCode >= 16 && e.keyCode <= 18 ) return;  // shift, ctr, alt
        else if( e.keyCode >= 35 && e.keyCode <= 40 ) return;  // home, end, left, up, right, down
        else if( e.keyCode == 13 ) return;  // enter
        else if( e.keyCode == 46 ) return;  // delete
        else if( e.keyCode == 20 ) return;  // capslock
        
        e.preventDefault();
    });
*/