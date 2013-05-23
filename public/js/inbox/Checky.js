//Object that controls Checkbox Feed Status

function Checky(opts) {
    this.feed_selection   = opts.feed_selection;
    this.check_feed_id    = opts.check_feed_id;
    this.category_feed_id = opts.category_feed_id;
    this.click_all        = opts.click_all;
    this.checky_bar       = opts.checky_bar;
}

Checky.prototype.init = function() {

    var me = this;    
    $(document).delegate(me.feed_selection, 'change', function(e) {
        var mode         = $(this).val();
        var checkFeed    = $(me.check_feed_id);
        var categoryFeed = $(me.category_feed_id);
        var ifChecked    = checkFeed.is(':checked');
        var currentUrl   = $(location).attr('href');
        var baseUrl      = $(this).attr('base-url');
        var checkyBar    = $('.checky-bar');
        var collection   = new Array();
        var exam_collection = new Array();

        if (ifChecked && mode != 'none') {

            var conf, color, parent_id;
            var feedback_str = ( $(me.check_feed_id + ':checked').length == 1 ? 'this feedback?' : 'these feedbacks?' );

            var checkedFeedCount = checkFeed.filter(':checked').length;

            if (mode == 'restore' || mode == 'inbox') {
                conf = confirm_message("restore", checkedFeedCount);
            }
           
            if (mode == 'remove') {
                conf = confirm_message("permanently remove", checkedFeedCount); 
            }
           
            if (mode == 'publish') {
                conf = confirm_message("publish", checkedFeedCount); 
            }
           
            if (mode == 'feature') { 
                conf = confirm_message("feature", checkedFeedCount); 
            }
           
            if (mode == 'delete') {
                conf = confirm_message("delete", checkedFeedCount); 
            } 

            if (conf) {
                checkFeed.each(function() {
                    if ($(this).is(':checked')) {
                        if ( $('#' + $(this).val()).is(":hidden") == false ) {
                            
                            var my_parent  = $(this).parents('div.feedback-group')
                            var my_ratings = $(this).siblings('.feed-ratings').val();
                            var my_perm = $(this).siblings('.perm-state').val();
                            var feed_unit  = '#' + $(this).val();

                            var data = {  
                                "feedid": $(this).val()
                              , "contactid": $(this).siblings('.contact-feed-id').val()
                              , "siteid": $(this).siblings('.site-feed-id').val()
                              , "rating": $(this).siblings('.feed-ratings').val()
                              , "parent_id": my_parent.attr('id')
                              , "perm": my_perm
                              , "mode": mode
                              , "total_units": my_parent.attr('data-total') 
                            };

                            console.log(my_perm);
                            console.log(my_ratings);
                            console.log(mode);

                            //console.log(window.location.pathname.match(/published|contacts/g));                             
                            if(my_ratings != 'POOR' && my_perm == 1) { 
                                console.log("all can pass");
                                //process_feedbacks(collection, data, feed_unit); 
                            } 

                            if((my_ratings != 'POOR' && my_perm == 0) && (mode == 'publish' || mode == 'feature')) {
                                console.log("private and limited feeds cannot pass");
                                //process_feedbacks(collection, data, feed_unit); 
                            }

                            /*
                            if(my_ratings != 'POOR' && my_perm == 1) { 
                                console.log("all can pass");
                                //process_feedbacks(collection, data, feed_unit); 
                            } 
                           
                            if((my_ratings != 'POOR' && my_perm == 0) && (mode == 'delete' || mode == 'restore' || mode == 'remove')) {
                                console.log("private and limited feeds cannot pass");
                                //process_feedbacks(collection, data, feed_unit); 
                            }

                            if(my_ratings == 'POOR' && (mode == 'delete' || mode == 'restore' || mode == 'remove')) { 
                                console.log("poor rated feeds cannot pass");  
                                //process_feedbacks(collection, data, feed_unit); 
                            } 
                            */

                            //exam_collection.push(data);
                        } 
                    }
                });    

                var restricted_feeds = exam_collection.filter(function(el) {
                    return (el.perm == 3 || el.rating == 'POOR') && (el.mode == 'publish' || el.mode == 'feature');
                });

                if(restricted_feeds.length > 0) { 
                    if(restricted_feeds.length == 1) {
                        confirm("Warning: There is feedback that has been marked as private/limited or poor and will not be processed.");         
                    } else { 
                        confirm("Warning: There are feedback that have been marked as private/limited or poor and will not be processed.");     
                    }
                    
                    $.each(restricted_feeds, function(index, value) {
                        $("#" + value.feedid).animate({
                           backgroundColor: '#ff6666'
                        }, 800, function() {
                            $(this).animate({
                                backgroundColor: '#fff'
                            }, 800);
                        })
                    });
                }

                $("option:first", this).prop("selected", true);

                if(collection.length > 0) { 
                    newfeedback_process(collection);

                    $.ajax({
                        type: "POST"      
                      , data: {  
                          'col': mode
                        , 'feed_ids': collection
                        }
                      , url: $(this).attr("hrefaction")
                      , dataType: "json"
                      , beforeSend: function() {
                          var myStatus = new Status();
                          myStatus.notify("Processing...", 1000);
                      }
                      , success: function(msg) { 

                          $.ajax({url: "/feedback/bust_hostfeed_data"});

                          for(var key in msg.ui) {
                              $('#' + key).hide();
                          }

                          var message = msg.message;

                          checkyBar.css({
                              'background': '#fef1b5'
                            , 'width': '200px'
                            , 'right': '35%'
                            , 'top': '15%'
                            , 'text-align': 'center'
                            , 'padding': '5px'
                            , 'font-weight': 'bold'
                          }).html(message).show();
                          checkyBar.delay(1000).fadeOut('fast');
                          //this is for clicking to make this mothafucka vanish                          
                          mouse_is_inside = false;  
                       }
                    });

                }

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

function process_feedbacks(collection, data, units) {
    collection.push(data);
    //units to vanished
    $(units).fadeOut(300, function() { $(this).hide(); });       
}

function confirm_message(text, checkcount) {
    if(checkcount > 1) {
        return confirm("Are you sure you want to " + text + " these feedbacks?");     
    } else { 
        return confirm("Are you sure you want to " + text + " this feedback?");     
    }
}
