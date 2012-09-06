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
        var mode        = $(this).val();
        var checkFeed   = $(me.check_feed_id);
        var categoryFeed = $(me.category_feed_id);
        var ifChecked   = checkFeed.is(':checked');
        var currentUrl  = $(location).attr('href');
        var baseUrl     = $(this).attr('base-url');
        var checkyBar   = $('.checky-bar');
        var collection  = new Array();
        var exam_collection = new Array();

        if (ifChecked && mode != 'none') { 

            var conf, color, parent_id;

            if (mode == 'restore' || mode == 'inbox') {
                conf     = confirm("Are you sure you want to restore these feedbacks?");     
            }
           
            if (mode == 'remove') {
                conf  = confirm("Are you sure you want to permanently remove these feedbacks?");                  
            }
           
            if (mode == 'publish') {
                conf     = confirm("Are you sure want to publish these feedbacks?");     
            }
           
            if (mode == 'feature') {
                conf     = confirm("Are you sure want to feature these feedbacks?");     
            }
           
            if (mode == 'delete') {
                conf     = confirm("Are you sure want to delete these feedbacks?");     
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

                            //console.log(window.location.pathname.match(/published|contacts/g)); 
                            if(my_ratings != 'POOR' && my_perm == 1) { 
                                //console.log("all can pass");
                                process_feedbacks(collection, data, feed_unit); 
                            } 

                            if(my_ratings == 'POOR' && (mode == 'delete' || mode == 'restore' || mode == 'remove')) { 
                                //console.log("poor rated feeds cannot pass");  
                                process_feedbacks(collection, data, feed_unit); 
                            } 

                            if((my_ratings != 'POOR' && my_perm == 3/*(my_perm == 2 || my_perm == 3)*/) && (mode == 'delete' || mode == 'restore' || mode == 'remove')) {
                                //console.log("private and limited feeds cannot pass");
                                process_feedbacks(collection, data, feed_unit); 
                            }
                            exam_collection.push(data);
                        } 
                    }
                });    

                var limited_perm_feeds = exam_collection.filter(function(el) {
                    return (el.perm == 3 || el.perm == 2) && (el.mode == 'publish' || el.mode == 'feature');
                });

                var poor_feeds = exam_collection.filter(function(el) {
                    return el.rating == 'POOR' && (el.mode == 'publish' || el.mode == 'feature');
                });

                console.log(limited_perm_feeds);
                console.log(poor_feeds);
                
                /*
                if(limited_perm_feeds.length > 0) {
                    if(limited_perm_feeds.length == 1) {
                        confirm("Warning: This feedback has been set as private and will not be processed.");     
                    } else {
                        confirm("Warning: There is feedback that has been set as private and will not be processed.");    
                    }    
                }

                if(poor_feeds.length > 0) {
                    if(poor_feeds.length == 1) { 
                        confirm("Warning: This feedback has been rated as poor and will not be processed.");     
                    } else {
                        confirm("Warning: There is feedback that has been rated as poor and will not be processed.");     
                    } 
                }
                */
 
                $("option:first", this).prop("selected", true);
                if(collection.length > 0) { 
                    /*
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

                          //this is for clicking to make this mothafucka vanish                          
                          mouse_is_inside = false;  
                       }
                    });
                    */
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
