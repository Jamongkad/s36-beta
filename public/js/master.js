// convert \n to br tags.
function nl2br(s){
    return s.replace(/\n/g,'<br>');
}

// convert br tags to \n.
function br2nl(s){
    return s.replace(/<br ?\/?>/g,'\n');
}

// convert html to entities.
function html2entities(s){
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// convert entities to html.
function entities2html(s){
    return s.replace(/&amp;/g,'&').replace(/&lt;/g,'<').replace(/&gt;/g,'>');
}

function close_lightbox(){
    $('.lightbox-s').fadeOut('fast');
    $('#lightboxNotification').fadeOut('fast');
    return 0;
}

function display_error_mes(mes){
    $('.lightbox-message').addClass('error');
    $('.lightbox-message ul').html('').each(function(){
        $.each(mes,function(e,str){
            $('.lightbox-message ul').append('<li>'+str+'</li>'); 
        });
    });
    display_lightbox();
}

function display_lightbox(){
    $('#lightboxNotification').fadeIn();
    $('.lightbox-s').fadeIn();
    return false;
}