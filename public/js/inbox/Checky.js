function Checky(opts) {
    this.feed_selection   = opts.feed_selection;
    this.check_feed_id    = opts.check_feed_id;
    this.category_feed_id = opts.category_feed_id;
    this.click_all        = opts.click_all;
    this.checky_bar       = opts.checky_bar;
    this.count            = 0;
}

Checky.prototype.init = function() {

    var me = this;    
    $(document).delegate(me.feed_selection, 'change', function(e) {
        var mode        = $(this).val();
        var checkFeed   = $(me.check_feed_id);
        var categoryFeed = $(me.category_feed_id);
        var ifChecked   = checkFeed.is(':checked');
        var currentUrl  = $(location).attr('href');
        var baseUrl     = $(this).attr('base-url');
        var checkyBar   = $('.checky-bar');
        var collection  = new Array();

        if (ifChecked && mode != 'none') { 

            var conf, color, goto_url;

            if (mode == 'restore' || mode == 'inbox') {
                conf     = confirm("Are you sure you want to restore these feedbacks?");     
                color    = '#fef1b5';
                goto_url = 'inbox/all';
            }
           
            if (mode == 'remove') {
                conf  = confirm("Are you sure you want to permanently remove these feedbacks?");                  
                color = '#fef1b5';
            }
           
            if (mode == 'publish') {
                conf     = confirm("Are you sure want to publish these feedbacks?");     
                color    = '#66cd00';
                goto_url = 'inbox/published/all';
            }
           
            if (mode == 'feature') {
                conf     = confirm("Are you sure want to feature these feedbacks?");     
                color    = '#fbec5d';
                goto_url = 'inbox/featured/all';
            }
           
            if (mode == 'delete') {
                conf     = confirm("Are you sure want to delete these feedbacks?");     
                color    = '#fef1b5';
                goto_url = 'inbox/deleted';
            } 

            if (conf) {
                checkFeed.each(function() {
                    if ($(this).is(':checked')) {
                        if ( $('#' + $(this).val()).is(":hidden") == false ) {
                            collection.push({  "feedid": $(this).val()
                                             , "contactid": $(this).siblings('.contact-feed-id').val()
                                             , "siteid": $(this).siblings('.site-feed-id').val()
                                             , "rating": $(this).siblings('.feed-ratings').val()
                                             });

                            var feed_unit = '#' + $(this).val();
                            $(feed_unit).fadeOut(300, function() { $(this).hide(); });      
                            var my_parent = $(feed_unit).parents('div.feedback-group').children('div.feedback').is(":hidden");
                            console.log(my_parent);

                            /*
                            var my_parent = $(this).parents('div.feedback-group');
                            var count = my_parent.children('div.feedback').is(':hidden').length;
                            console.log(count);
                            if(count === 1)  {
                                my_parent.hide();
                            }
                            */
                        } 
                    }
                });    

                var collection_count = collection.length;
                $("option:first", this).prop("selected", true);
                var hideLink = " <a href='#' class='hide-checkybar'>Close</a>";
                /*
                $.ajax({
                    type: "POST"      
                  , data: {  col: mode
                           , feed_ids: collection
                           , cat_id: categoryFeed.val()
                           , curl: currentUrl }
                  , url: $(this).attr("hrefaction")
                  , dataType: "json"
                  , beforeSend: function() {
                      checkyBar.html("processing feedback...").css({"background": "#fef1b5"}).show();
                  }
                  , success: function(msg) {
                      var return_ids = msg.return_ids; 
                      var message = msg.message;
                      checkyBar.css({'width': '350px', 'right': '22%'});
                      checkyBar.hide();
                      
                      return_feedback(return_ids, checkyBar, mode, hideLink, message);

                      if(return_ids == null) { 
                          checkyBar.css({'background': color, 'width': '200px', 'right': '28%'})
                                   .html(notification_message(mode, collection_count, return_ids, hideLink))
                                   .show();
                      }

                      close_checkybar();
                   }
                });
                */
            }

            $(this).val("none");
            $('.click-all').attr('checked', false);
            checkFeed.attr('checked', false);
        } else {
            $('.click-all').attr('checked', false);
        } 
    });
}

Checky.prototype.clickAll = function() { 
    var me = this;    
    $(document).delegate(me.click_all, 'click', function(e) {
        if (this.checked) {
            $(me.check_feed_id).prop("checked", true);
            $(me.click_all).prop("checked", true); 
        } else {
            $(me.check_feed_id).prop("checked", false);
            $(me.click_all).prop("checked", false);
        }                                            
    });
}

function notification_message(mode, collection_count, return_ids, link) {
    return "<div>" + mode + ": " + (collection_count - ((return_ids != null) ? return_ids.length : 0)) + (collection_count > 1 ? " feedbacks" : " feedback") + link + "</div>";
}

function return_feedback(id, message_container, mode, link, message) {
    if(id != null) {   
        message_container.html("<div>" + message + link + "</div>").show();
        $(id).each(function(index, value) {
            $( 'div#' + value.feedid + '.feedback').fadeIn(300, function() { $(this).show() });
        });
    } 
}

function close_checkybar() { 
    $(".hide-checkybar").bind("click", function(e) {
        $(this).parents(".checky-bar").hide(); 
        e.preventDefault();
    });
}
