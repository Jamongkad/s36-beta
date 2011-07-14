jQuery(function($) {

    var height_const = 19;
    var mheight = $('.feedback-feeds').height() + ($('.filter-holder').height() * 2) + $('.form-select-holder').height() + $('.sort-by-holder').height()

    if(mheight) {
        var height =  mheight + height_const + 'px';      
    } else {
        var height = $('.main_content').height() + height_const + 'px';
    }
   
    $('.dash_holder').css({
        'height': height
    })

    $('ul.category-picker li').bind('click', function(e) {

        var deselect_this = false;
        var li = $('a', this);
        var href = li.attr('href');

        if($(this).hasClass('Matched')) {
            deselect_this = true;
            $(this).removeClass("Matched");
        } 

        $('ul.category-picker li').each(function() {
            $(this).removeClass("Matched");
        });

        if(!deselect_this) {
            $(this).addClass('Matched');
        }

        $.ajax({
              type: "GET"
            , url: href
        });

        e.preventDefault();
    });
});
