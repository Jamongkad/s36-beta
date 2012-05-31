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
                            var feed_unit  = '#' + $(this).val();

                            var data = {  
                                "feedid": $(this).val()
                              , "contactid": $(this).siblings('.contact-feed-id').val()
                              , "siteid": $(this).siblings('.site-feed-id').val()
                              , "rating": $(this).siblings('.feed-ratings').val()
                              , "parent_id": my_parent.attr('id')
                              , "total_units": my_parent.attr('data-total') 
                            };

                            if(my_ratings != 'POOR') { 
                                process_feedbacks(collection, data, feed_unit); 
                            } 

                            if(my_ratings == 'POOR' && (mode == 'delete' || mode == 'restore' || mode == 'remove')) {
                                process_feedbacks(collection, data, feed_unit); 
                            }
                        } 
                    }
                });    

                var collection_count = collection.length; 
                         
                $("option:first", this).prop("selected", true);
                var hideLink = " <a href='#' class='hide-checkybar'>Close</a>";
                
                if(collection_count > 0) { 
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
                            }).html(message)
                                   .show();
                          close_checkybar();

                          checkyBar.hover(function() { 
                              mouse_is_inside = true;  
                          }, function() { 
                              mouse_is_inside = false;  
                          });
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

function process_feedbacks(collection, data, units) {
    collection.push(data);
    //units to vanished
    $(units).fadeOut(300, function() { $(this).hide(); });       
}
