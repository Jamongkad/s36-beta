// convert \n to br tags.
var Helpers = new function() {
    this.nl2br = function(s) {
        return s.replace(/\n/g,'<br>');       
    };

    this.br2nl = function(s) {
        return s.replace(/<br ?\/?>/g,'\n');       
    };

    this.html2entities = function(s) {
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');     
    };

    this.entities2html = function(s) {
        return s.replace(/&amp;/g,'&').replace(/&lt;/g,'<').replace(/&gt;/g,'>');       
    };
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
