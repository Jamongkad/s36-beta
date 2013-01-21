// convert \n to br tags.
var Helpers = new function() {

    var me = this;

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

    this.close_lightbox = function() { 
        $('.error-close-button').bind("click", function(e) {
            $('.lightbox-s').fadeOut('fast');
            $('#lightbox').fadeOut('fast');
            $('#lightboxNotification').fadeOut('fast');
            e.preventDefault();
        });
    };

    this.display_error_mes = function(mes) { 
        $('.lightbox-message').addClass('error');
        $('.lightbox-message ul').html('').each(function(){
            $.each(mes,function(e,str){
                $('.lightbox-message ul').append('<li>'+str+'</li>'); 
            });
        });

        me.display_lightbox();
    };

    this.display_lightbox = function() { 
        $('#lightboxNotification').fadeIn();
        $('#lightbox').fadeIn();
        $('.lightbox-s').fadeIn();
        return false;
    };
}
