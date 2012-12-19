function s36Lightbox(width, height, insertContent) {	

    var theLightbox = jQuery('<div class="lightbox"></div>');
    jQuery(theShadow).click(function(e){
            closeLightbox();
    });
    jQuery('body').append(theLightbox);

    jQuery('.lightbox').empty();
    if(insertContent != null){
        //This is just a test
        jQuery('.lightbox').append(insertContent + "<div class='lightbox-comment' style='color:#000;position:absolute;top:10px;right:10px;z-index:100002'>This is a preview only | <span style='cursor:pointer'>close</span></div>");
    }

    jQuery('.lightbox-comment').click(function(e){
        closeLightbox();
    });

    //set negative margin for dynamic width
    var margin = Math.round(width / 2);

    // set the css and show the lightbox
    jQuery('.lightbox').css('top', jQuery(window).scrollTop() + 50 + 'px');
    jQuery('.lightbox').css({
            'width':width,
            'height':height,
            'margin-left':"-"+margin+"px"
            });

    jQuery('.lightbox').fadeIn('fast');
}

function closeLightbox(){
    jQuery('.lightbox').fadeOut('fast');
}    
