jQuery(function($) {

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

    $('.fileas').bind('click', function(e) {     
        $(this).siblings('div.category-picker-holder').toggle();
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
            var undobar = $('div.undo-bar');

            undobar.empty();
            undobar.html('Deleted Feedback');

            $.ajax({
                  type: "GET"
                , url: feedurl
                , success: function(data) { 
                    var obj = jQuery.parseJSON(data);
                    $.each(obj, function(idx, val) {
                        var divTag = document.createElement("div");
                        var undoLinks = document.createElement("a");

                        undoLinks.setAttribute("href", "feedback/undodelete/" + val.id);
                        undoLinks.setAttribute("restore-id", val.id);
                        undoLinks.innerHTML = val.id;

                        divTag.className = "dickies";
                        divTag.appendChild(undoLinks);
                        undobar.append(divTag);
                    });

                    restoreUrl();
                    deleteDivCount(undobar);
                    undoAll();
                }
            });
        }
    });

    restoreUrl();
    deleteDivCount($('div.undo-bar'));
    undoAll();

    function undoAll() { 
        $('div.undoall a').bind('click', function(e) {
            var href = $(this).attr('href');
            $.ajax({
                url: href
              , success: function(data) {
                    window.location = "inbox";       
                }
            }); 
           
            e.preventDefault();
        });
    }

    function deleteDivCount(undobar) {
        
        if($('div.dickies').length >= 5) {

            undobar.empty();
            undobar.html('Deleted Feedback');
         
            var divTag = document.createElement("div");
            var undoAllLinks = document.createElement("a");
            undoAllLinks.setAttribute("href", "feedback/undodelete/all");
            undoAllLinks.innerHTML = "undo all";
         
            divTag.className = "dickies undoall";
            divTag.appendChild(undoAllLinks);
            undobar.append(divTag);
        }
    }

    function restoreUrl() { 
        $('div.dickies a').bind('click', function(e) {
            var dickiesUrl = $(this);
            $.ajax({
                url: dickiesUrl.attr('href')
            });
            $("#" + dickiesUrl.attr('restore-id')).fadeIn();
            dickiesUrl.parent('div.dickies').remove();
            e.preventDefault();
        });
    }

    $.fn.switcharoo = function(background_pos) {
        $(this).bind('click', function(e) { 
            var feedurl = $(this).attr('hrefaction');
            var feedid = $(this).attr('feedid');
            var state = $(this).attr('state');

            var var_state = null;

            if(state == 0) {
                var_state = 1;
                $(this).attr('state', 1);
                $(this).css({'background-position': background_pos});
            }

            if(state == 1) {
                var_state = 0;
                $(this).attr('state', 0);
                $(this).removeAttr('style');
            }

            $.ajax({
                  type: "POST"
                , url: feedurl
                , data: {"state": var_state, "feedid": feedid}
            });

            e.preventDefault(); 
        });
    }
      
    $('.check').switcharoo('0px bottom');
    $('.flag').switcharoo('-100px bottom');
    $('.feature').switcharoo('-60px bottom');
   
    $.each($('ul#nav-menu li'), function(index, value) {
        $(value).bind('click', function(e) {
            window.location = $(this).children('a').attr('href');
        });
    });

    $('select[name="feedback-limit"]').bind('change', function(e) {
        window.location = "?limit=" + $(this).val();
    });
});
