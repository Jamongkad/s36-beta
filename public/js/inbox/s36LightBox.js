function s36Lightbox(width, height, insertContent) {	
    if(jQuery('#lightbox').size() == 0){
        var theLightbox = jQuery('<div id="lightbox"></div>');
        var theShadow = jQuery('<div id="lightbox-shadow"/>');
        jQuery(theShadow).click(function(e){
                closeLightbox();
        });
        jQuery('body').append(theShadow);
        jQuery('body').append(theLightbox);
    }
    jQuery('#lightbox').empty();
    if(insertContent != null){
        //This is just a test
        jQuery('#lightbox').append(insertContent + "<div id='lightbox-comment' style='color:#fff;position:absolute;top:-20px;right:10px;'>This is a preview only | <span style='cursor:pointer'>close</span></div>");
    }

    jQuery('#lightbox-comment').click(function(e){
        closeLightbox();
    });

    //set negative margin for dynamic width
    var margin = Math.round(width / 2);

    // set the css and show the lightbox
    jQuery('#lightbox').css('top', jQuery(window).scrollTop() + 50 + 'px');
    jQuery('#lightbox').css({
            'width':width,
            'height':height,
            'margin-left':"-"+margin+"px"
            });

    jQuery('#lightbox').fadeIn('fast');
    jQuery('#lightbox-shadow').fadeIn('fast');
}

function closeLightbox(){
    jQuery('#lightbox').fadeOut('fast',function(){jQuery(this).empty();});
    jQuery('#lightbox-shadow').fadeOut('fast');
}    
