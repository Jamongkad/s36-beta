$(document).ready(function(){

    $(".inbox-fancybox-image").fancybox({
        openEffect : 'none',
        closeEffect : 'none'
    });

    $(".inbox-fancybox-video").click(function(e) {
        $.fancybox({
            'padding'       : 0,
            'autoScale'     : false,
            'transitionIn'  : 'none',
            'transitionOut' : 'none',
            'title'         : this.title,
            'width'         : 640,
            'height'        : 385,
            'href'          : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
            'type'          : 'swf',
            'swf'           : {
            'wmode'             : 'transparent',
            'allowfullscreen'   : 'true'
        }
        });
        e.preventDefault();
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
