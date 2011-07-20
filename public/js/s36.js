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

    //TODO: fix this states should be boolean values. 
    $('.makesticky').bind('click', function(e) {

        var href = $(this).attr('hrefaction');
        var text = $(this).attr('state');

        if(text == 'Make Sticky') {
            $(this).attr('state', 'Stickied')
            $(this).css({'background-position': '-60px bottom'});
        }

        if(text == 'Stickied') {
            $(this).attr('state', 'Make Sticky');
            $(this).removeAttr('style');
        }

        $.ajax({
              type: "GET"
            , url: href
            , data: {state: text}
        });

        e.preventDefault(); 
    });

    $('select[name="status"], select[name="priority"]').hide();

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

    $('span.priority-change').bind('click', function(e) { 
        $(this).children('select').unbind('change.priority').bind('change.priority', function(e) { 
            var select = $(this);
            var select_val = select.val();
            var feedid = select.attr('feedid');
            var feedurl = select.attr('feedurl');
            
            $.ajax({
                  type: "POST"
                , url: feedurl
                , data: {"select_val":select_val, "feed_id": feedid}
            });

            select.siblings().text($(this).children('option:selected').text());
        }).show();
    }).css({'cursor': 'pointer'})
    
    $('.remove').bind('click', function(e) {
        if(confirm('Are you sure?')) { 
            var my_parent = $(this).parents('div.feedback').fadeOut();
            var feedurl = $(this).attr('hrefaction');
            
            $.ajax({
                  type: "DELETE"
                , url: feedurl
            });
        }
    });

    $('.flag').bind('click', function(e) {

        var feedurl = $(this).attr('hrefaction');
        
        $.ajax({
              type: "GET"
            , url: feedurl
        });

    });
});
