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
});
