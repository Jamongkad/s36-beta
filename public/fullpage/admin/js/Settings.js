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