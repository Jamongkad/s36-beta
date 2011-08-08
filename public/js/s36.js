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

    $('div.undo-bar').hide(); 
    var deleteCount = 0;
    $('.remove').bind('click', function(e) {
        if(confirm('Are you sure?')) { 

            var my_parent = $(this).parents('div.feedback').fadeOut();
            var feedurl = $(this).attr('hrefaction');
            var undobar = $('div.undo-bar');

            deleteCount += 1;

            $.ajax({
                  url: feedurl
                , success: function(data) { 
                    var obj = jQuery.parseJSON(data);
                    $('li.delete sup').addClass('count').html(obj.total_rows);
                    $.each(obj.result, function(idx, val) {

                        var divTag = document.createElement("div");
                        var undoLinks = document.createElement("a");
                        var hideLink = document.createElement("a");

                        undoLinks.setAttribute("id", "undo-links");

                        hideLink.setAttribute("href", "#");
                        hideLink.setAttribute("id", "hide-undo-bar");
                        hideLink.innerHTML = " Hide";

                        divTag.className = "undo-delete";
                        if(deleteCount == 1) {
                            divTag.innerHTML = deleteCount + " feedback has been moved to the Trash ";     
                            undoLinks.setAttribute("href", undobar.attr('delete_action') + val.id);
                            undoLinks.setAttribute("restore-id", val.id);
                            undoLinks.setAttribute("delete-mode", "single");
                            undoLinks.innerHTML = "Undo";
                        } else {
                            divTag.innerHTML = deleteCount + " feedbacks have been moved to the Trash ";
                            undoLinks.setAttribute("href", undobar.attr('goto_trash'));
                            undoLinks.setAttribute("delete-mode", "multiple");
                            undoLinks.innerHTML = "Go to Trash";
                        }                       
                        divTag.appendChild(undoLinks);
                        divTag.appendChild(hideLink);
                        undobar.html(divTag); 
                    });
                    restoreUrl();
                }
            });
            undobar.show();
        }
    });

    restoreUrl();

    $('a.restore-feed').bind('click', function(e) { 
        var my_parent = $(this).parents('div.feedback').fadeOut();
        console.log($(this).attr('href'));
        e.preventDefault();
    })

    function restoreUrl() { 
        $('div.undo-delete a#undo-links').bind('click', function(e) {
            var undoDelete = $(this);
            var deleteMode = undoDelete.attr('delete-mode');            

            var deleteSup = $('li.delete sup');
            var deleteSupNum = deleteSup.addClass('count').html();

            if(deleteMode == 'single') {
                deleteSupNum -= 1;     
            } 

            deleteSup.addClass('count').html(deleteSupNum); 

            if(deleteMode == 'single' || !deleteMode) { 

                $.ajax({
                    url: undoDelete.attr('href')
                });
              
                $("#" + undoDelete.attr('restore-id')).fadeIn();
                undoDelete.parent('div.undo-delete').remove();
                $('div.undo-bar').hide();

            } else {
                window.location = undoDelete.attr('href');
            }
            deleteCount = 0;
            e.preventDefault();
        });

        $("div.undo-delete a#hide-undo-bar").bind('click', function(e) { 
            $('div.undo-bar').hide();
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
    
    //TODO: DUPLICATE
    $('.user-info input[name*="display"]').bind('click', function(e) {
        var val = this.checked;
        var name = $(this).attr('name');
        var feed_id = $('#feed-id').val();
        
        $.ajax({
              type: "POST"     
            , url: "/index.php/feedback/toggle_feedback_display"
            , data: {feedid: feed_id, check_val: val, column_name: name}
        });
    });

    $('.display-info input[name*="display"]').bind('click', function(e) {
        var val = this.checked;
        var name = $(this).attr('name');
        var feed_id = $('#feed-id').val();
        
        $.ajax({
              type: "POST"     
            , url: "/index.php/feedsetup/toggle_feedback_display"
            , data: {feedblock_id: feed_id, check_val: val, column_name: name}
        });
    });
});
