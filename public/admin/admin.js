// JavaScript Document

/* ADMIN VIEW CSS Document 

    Date: 01/03/2013
    Version: 0.0.0.0
*/

$(document).ready(function(){
    $('#adminWindowBox').draggable({ handle: '#adminWindowTitleBar',opacity:0.5});
    $('#adminWindowTitleBar .closeBtn').click(function(){
        $('#adminWindowBox').fadeOut('fast');
    });
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
    $('.backgroundColorPicker').on('change',function(){
        change_background_color($(this).val(),$(this).attr('data-opacity'));
    });
    $('.btnBgColor').on('change',function(){
        change_button_color($(this).val());
    });
    $('.mbtnBgColor').on('change',function(){
        change_mouseover_button_color($(this).val());
    });
    $('.btnFontColor').on('change',function(){
        change_button_font_color($(this).val());
    });
    /*$('#patterns').jcarousel({  // go home! you're drunk!
        scroll: 5,
        initCallback: function(){},
        buttonNextHTML: '#patternPrev',
        buttonPrevHTML: '#patternNext'
    });*/
    $('.patternItem').click(function(){
        $('.patternItem.active').removeClass('active');
        $(this).addClass('active');
        apply_pattern_design($(this).attr('id'));
    });
    
    /*var $adminPage = $('#adminWindowPages').cycle({  // go home! you're drunk!
        fx: 'fade', speed: 100, timeout: 0, before: adjust_window_height
    });
    $('#adminWindowMenuBar ul li').click(function(){
        $('#adminWindowMenuBar ul li .active').removeClass('active');
        $(this).find('a').addClass('active');
        var index = $(this).index();
        $adminPage.cycle(index);
    });*/
    // file upload script
    $('#bg_image').fileupload({
        dropZone: '#bgDragBox',
        dataType: 'json',
        add: function(e, data){
            var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
            if( image_types.indexOf( data.files[0].type ) == -1 ){
                var error = ['Please select an image file'];
                display_error_mes(error);
                return false;
            }
            if( data.files[0].size > 2000000 ){
                var error = ['Please upload an image that is less than 2mb'];
                display_error_mes(error);
                return false;
            }
            data.submit();
        },progress: function(e, data){
            showNotification('Uploading Background Image', 0);
        },done: function(e, data){
            change_background_image(data.result[0].url);
            hideNotification();
        }
    });
    //cover photo file upload script
    $('#cv_image').fileupload({
        dataType: 'json',
        add: function(e, data){
            var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
            if( image_types.indexOf( data.files[0].type ) == -1 ){
                var error = ['Please select an image file'];
                display_error_mes(error);
                return false;
            }
            if( data.files[0].size > 2000000 ){
                var error = ['Changing cover image..'];
                display_error_mes(error);
                return false;
            }
            data.submit();
        },progress: function(e, data){
            showNotification('Changing Cover Photo',0);
        },done: function(e, data){
            change_cover_image(data.result[0].url);
        }
    });
    
    
    $('.bgPos').click(function(){
        $('.bgPos.active').removeClass('active');
        $(this).addClass('active');
    });
    $('.bgRepeat').click(function(){
        $('.bgRepeat.active').removeClass('active');
        $(this).addClass('active');
    });
    $('#bg_pos_l').click(function(){
        change_background_position('left');
    });
    $('#bg_pos_c').click(function(){
        change_background_position('center');
    });
    $('#bg_pos_r').click(function(){
        change_background_position('right');
    });
    $('#bg_pos_t').click(function(){
        change_background_position('top');
    });
    $('#bg_pos_b').click(function(){
        change_background_position('bottom');
    });
    $('#bg_repeat_r').click(function(){
        change_background_repeat('repeat');
    });
    $('#bg_repeat_nr').click(function(){
        change_background_repeat('no-repeat');
    });
    $('#bg_repeat_rh').click(function(){
        change_background_repeat('repeat-x');
    });
    $('#bg_repeat_rv').click(function(){
        change_background_repeat('repeat-y');
    });
    $('#saveCoverButton').click(function(){
        upload_to_server();
    });
});
function apply_pattern_design(filename){
    $('body').css('background-image','url(images/patterns/'+filename+')');
}
function change_background_image(path){
    $('body').css('background-image','url('+path+')');
    $('#bodyColorOverlay').css('opacity',0);
}
function change_cover_image(path){
    $('<img />')
        .attr('src', path)
        .load(function(e){
            make_cover_undraggable(false);          
            $('#coverPhoto img').attr({'src':path,width:'100%'});
            $('#coverPhoto img').css('top', 0);
            $('#saveCoverButton').show();
            $('#changeCoverButton').hide();
            hideNotification();
    });
    
}
function change_background_repeat(rules){
    $('body').css('background-repeat',rules);
}
function change_background_position(pos){
    $('body').css('background-position',pos);
}
function change_button_font_color(hex){
    var elem = $('.send-button a');
    elem.css({'color':hex});    
}
function change_button_color(hex){
    var elem = $('.send-button a');
    elem.css({'background-color':hex}); 
}
function change_mouseover_button_color(hex){
    var elem = $('.send-button a');
    elem.hover(function(){
        $(this).css({'background-color':hex});  
    },function(){
        var althex = $('.btnBgColor').val();
        $(this).css({'background-color':althex});   
    });
}
function change_background_color(hex,opc){
    var elem = $('#bodyColorOverlay');
    elem.css({'background-color':hex,'opacity':opc});
}
function adjust_window_height(curr, next, opts, fwd) {
    var $ht = $(this).height();
    $(this).parent().animate({"height":$ht},'fast');
}
function showNotification(mes,delay){
    var delay = delay;
    $('#notification-message').empty().html(mes);
    $('#notification').animate({ height: '50', opacity: '100' }, 'fast','',function(){
        if(delay){
            setTimeout(hideNotification,delay);     
        }
    });
}
function hideNotification(){
    $("#notification").animate({ height: 0, opacity: 0 }, 'fast');
}
function make_cover_undraggable(opt){
    
    if(!opt){
        $("#coverPhoto img").load(function(){
            $('#dragPhoto').fadeIn();
            var offset = $(this).parent().offset();
            var offsetX = offset.left;
            $(this).each(function(){
                
                var imgH = $(this).height();
                var parH = $(this).parent().height();
                var imgW = $(this).width();
                var parW = $(this).parent().width();  
                var ipH = imgH-parH;
                var ipW = imgW-parW-offsetX;
                $(this).draggable({ containment: [-ipW, -ipH, offsetX, 0], scroll: false, disabled: opt});
            });
        });
    }else{
        $('#dragPhoto').fadeOut();
        $("#coverPhoto img").draggable({disabled: true});
    }
}
function upload_to_server(data){
    /* pass the variables from here to the database then initialize the codes below if upload to db is successful */
    $.ajax({
        url: '/imageprocessing/savecoverphoto',
        type: 'post',
        data: {
            'src': $('#coverPhoto img').attr('src'), 
            'top': $('#coverPhoto img').css('top')
        },
        success: function(result){
            console.log('resuuuulllt');
        }
    });
    
    $('#saveCoverButton').html('Cover Saved');
    var timeout;
    if(timeout) {
        clearTimeout(timeout);
        timeout = null;
    }
    timeout = setTimeout(hide_save_button, 1000);
}
function hide_save_button(){
    
    $('#saveCoverButton').fadeOut('fast',function(){
        $(this).html('Save Cover');
    });
    $('#changeCoverButton').fadeIn('fast');
    $('#dragPhoto').fadeOut('fast');
    make_cover_undraggable(true);
    
}