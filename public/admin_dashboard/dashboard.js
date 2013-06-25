$(document).ready(function(){
    $('.action-delete').hover(function(){
        $(this).next().fadeIn('fast');
    },function(){
        $(this).next().fadeOut('fast');
    });

});
/* removed for the mean time. buggy as hell
$(window).scroll(function() {
    
    var currentScroll = $('html').scrollTop() || $('body').scrollTop();
    if($(window).width() <= 600) {
        top_margin = 270;
    } else {
        top_margin = 200;
    }
    $('.dashboard-feedback').each(function(){

        var top_offset = $(this).offset().top;
        var bot_offset = $(this).height() + top_offset - currentScroll;
        
        //console.log('element : ' + $(this).index() + ' | current :' +currentScroll + ' | top offset :' + top_offset + ' | bot_offset :' + bot_offset);
            
        var add_margin = 40 + currentScroll - top_offset;

        if((currentScroll >= top_offset) && (bot_offset >= top_margin)) {
            console.log('boom!' + $(this).index());
            $(this).find('.feedback-action-menu').css('top',add_margin);
        } else {
            $(this).find('.feedback-action-menu').css('top',0); 
        }
    });
    
});
*/
