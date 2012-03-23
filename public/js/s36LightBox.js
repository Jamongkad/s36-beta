jQuery(function($) { 
    //helper functions ABSTRACT THIS MOTHAFUCKER 
    function s36Lightbox(width, height, insertContent) {	
        if($('#lightbox').size() == 0){
            var theLightbox = $('<div id="lightbox"></div>');
            var theShadow = $('<div id="lightbox-shadow"/>');
            $(theShadow).click(function(e){
                    closeLightbox();
            });
            $('body').append(theShadow);
            $('body').append(theLightbox);
        }
        $('#lightbox').empty();
        if(insertContent != null){
            //This is just a test
            $('#lightbox').append(insertContent + "<div id='lightbox-comment' style='color:#fff;position:absolute;top:-20px;right:10px;'>This is a preview only | <span style='cursor:pointer'>close</span></div>");
        }

        $('#lightbox-comment').click(function(e){
            closeLightbox();
        });

        //set negative margin for dynamic width
        var margin = Math.round(width / 2);

        // set the css and show the lightbox
        $('#lightbox').css('top', $(window).scrollTop() + 50 + 'px');
        $('#lightbox').css({
                'width':width,
                'height':height,
                'margin-left':"-"+margin+"px"
                });

        $('#lightbox').fadeIn('fast');
        $('#lightbox-shadow').fadeIn('fast');
    }

    function closeLightbox(){
        $('#lightbox').fadeOut('fast',function(){$(this).empty();});
        $('#lightbox-shadow').fadeOut('fast');
    }    
});
