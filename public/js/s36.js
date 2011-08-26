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
        //TODO: maaaaaan clean this up!
        $(this).parents('.category-picker-holder').siblings('.feature, .check').removeAttr('style').attr('state', 0);
        $(this).parents('.g4of5').siblings('.status-message').html('<span style="background-color: #3a4c5c; color: #f0f0f0">FILE AS: '+li.text()+"</span>");
        $.ajax( { type: "POST", url: href } );
        e.preventDefault();
    });

    $('div.category-picker-holder').hide();

    $('.fileas').bind('click', function(e) {     
        $(this).siblings('div.category-picker-holder').toggle();

        if($(this).attr('style')) {
            $(this).removeAttr('style'); 
        } else {
            $(this).css({"background-position": "-20px bottom"});     
        }
        
        e.preventDefault();
    });

    $('select[name="status"], select[name="priority"]').hide();

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
        $.ajax({url: $(this).attr('href')});
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

    $('select[name="rating-limit"]').bind('change', function(e) {
        window.location = "?rating=" + $(this).val();
    });
    
    var userInfo = new FeedbackDisplayToggle({feed_id: $('#feed-id'), hrefaction: $('#toggle_url')});
    userInfo.toggleDisplays($('.user-info input[name*="display"]'), 'feedid');
    userInfo.toggleDisplays($('.display-info input[name*="display"]'), 'feedblock_id');

    var check = new Checky({ delete_selection: $('.delete-selection'), check_feed_id: $('.check-feed-id'), 
                             contact_feed_id: $('.contact-feed-id'), site_feed_id: $('.site-feed-id'), click_all: $('.click-all') });
    check.init(); 
    check.clickAll();

    var statusChange = new DropDownChange({status_element: $('span.status-change'), status_selector: 'change.status'});
    statusChange.enable();

    var priorityChange = new DropDownChange({status_element: $('span.priority-change'), status_selector: 'change.priority'});
    priorityChange.enable();
});
