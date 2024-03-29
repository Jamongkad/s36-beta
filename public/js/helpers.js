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
    
    this.links_to_urls = function(s){
        return s.replace(/<a.+?>/g, '').replace(/<\/a>/g, '');
    }
    
    this.urls_to_links = function(s){
        var link = '<a href="http://$1" target="_blank">$1</a>';
        s = s.replace(/((https?\:\/\/)?(www\.)?[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})(\/+[a-z0-9_.\:\;-]*)*(\?[\&\%\|\+a-z0-9_=,\.\:\;-]*)?([\&\%\|\+&a-z0-9_=,\:\;\.-]*)([\!\#\/\&\%\|\+a-z0-9_=,\:\;\.-]*)}*)/gi, link);
        s = s.replace(/http\:\/\/http/gi, 'http');
        return s;
    }
    
    this.fb_comment_str = function(s){
        return me.nl2br(me.html2entities( s.replace(/^\s+|\s+$/g, '').replace(/[\n]{3,}/g, '\n\n') ));
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
        $('#lightboxNotification .lightbox-message ul').html('').each(function(){
            $.each(mes,function(e,str){
                $('.lightbox-message ul').append('<li>'+str+'</li>'); 
            });
        });

        me.display_lightbox();
    };

    this.display_lightbox = function() { 
        $('#lightboxNotification').fadeIn();
        $('#lightboxNotification .lightbox-button').click(function(e){
            $('#lightboxNotification').fadeOut('fast');
            e.preventDefault();
        });
        return false;
    };
    
    this.get_random_int = function(min, max){
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    
    this.get_random_str = function(len){
        var str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        var rand_str = '';
        for( a = 1; a <= len; a++ ){
            rand_str += str.charAt( this.get_random_int(1, 26) );
        }
        return rand_str;
    }
    
    this.add_ellipse = function(str, len){
        return ( str.length > len ? str.substr(0, len) + '...' : str );
    }
    
    /* ========================================
    || Display an awesome notification, mes = messages in array, delay = integer in millisecond
    ==========================================*/
    this.show_notification = function(mes, delay){
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
    
}
