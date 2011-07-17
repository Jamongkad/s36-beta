jQuery(function($) {

    var mheight = $('.feedback-feeds').height() + ($('.filter-holder').height() * 2) + $('.form-select-holder').height() + $('.sort-by-holder').height();

    var height = null;

    if(mheight) {
        var height = mheight + 16 + 'px';      
    } else {

        var main_content_hgt = $('.main_content').height();

        if(main_content_hgt < 500) {
            main_content_hgt = 600; 
        }

        var height = main_content_hgt + 'px';
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

        $(this).parent().children().each(function() {
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

    $('div.category-picker-holder').hide();

    $('a.fileas').bind('click', function(e) {     
        $(this).siblings('div.category-picker-holder').toggle();
        e.preventDefault();
    });

    $('a.makesticky').bind('click', function(e) {

        var href = $(this).attr('href');
        var text = $(this).text();

        if(text == 'Make Sticky') {
            $(this).text('Stickied')
        }

        if(text == 'Stickied') {
            $(this).text('Make Sticky');
        }

        $.ajax({
              type: "GET"
            , url: href
            , data: {state: text}
        });

        e.preventDefault(); 
    });

    $('select[name="status"]').hide();

    $('span.status-change').bind("click", function(e) {

        $(this).children('select').unbind('change.status').bind('change.status', function(e) {
            var select = $(this);
            var select_val = select.val();
            var feedid = select.attr('feedid');
            var feedurl = select.attr('feedurl');

            $.ajax({
                  type: "POST"
                , url: feedurl
                , data: {"select_val":select_val, "feed_id": feedid}
            });

            select.siblings().text(select_val);
        }).show();

    }).css({'cursor': 'pointer'});



});
