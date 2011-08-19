function Checky(opts) {
    this.delete_selection = opts.delete_selection;
    this.check_feed_id = opts.check_feed_id;
    this.click_all = opts.click_all;
    this.count = 0;
}

Checky.prototype.init = function() {
    var me = this;    
   
    $(me.delete_selection).bind('change', function(e) {
        var mode = $(this).val();
        var checkFeed = me.check_feed_id;
        var ifChecked = checkFeed.is(':checked');
        var currentUrl = $(location).attr('href');
        var baseUrl = $(this).attr('base-url');

        var collection = new Array();
       
        if(ifChecked && mode != 'none') { 

            var conf = null; 
            var color = null; 
            var goto_url = null;

            if(mode == 'restore' || mode == 'inbox') {
                conf = confirm("Are you sure you want to restore these feedbacks?");     
                color = '#fef1b5';
                goto_url = 'inbox/all';
            }
           
            if(mode == 'remove') {
                conf = confirm("Are you sure you want to permanently remove these feedbacks?");                  
                color = '#fef1b5';
            }
           
            if(mode == 'publish') {
                conf = confirm("Are you sure want to publish these feedbacks?");     
                color = '#66cd00';
                goto_url = 'inbox/published/all';
            }
           
            if(mode == 'feature') {
                conf = confirm("Are you sure want to feature these feedbacks?");     
                color = '#fbec5d';
                goto_url = 'inbox/featured/all';
            }
           
            if(mode == 'delete') {
                conf = confirm("Are you sure want to delete these feedbacks?");     
                color = '#fef1b5';
                goto_url = 'inbox/deleted';
            } 

            if(conf) {
               checkFeed.each(function() {
                    if($(this).is(':checked')) {
                        collection.push($(this).val());
                        $('#' + $(this).val()).fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                });    
            }
            //revert to default -- select
            $("option:first", this).prop("selected", true);
           
            var hideLink = document.createElement("a");
            hideLink.setAttribute("href", "#");
            hideLink.setAttribute("id", "hide-checkybar");
            hideLink.style.color = "#00688b";
            hideLink.style.fontSize = "0.7em";
            hideLink.style.marginLeft = "3px";
            hideLink.style.textDecoration = "underline";
            hideLink.innerHTML = "hide";

            var gotoLink = document.createElement("a");
            gotoLink.setAttribute("href", baseUrl + goto_url);
            gotoLink.style.color = "#00688b";
            gotoLink.style.fontSize = "0.7em";
            gotoLink.style.marginLeft = "5px";
            gotoLink.style.textDecoration = "underline";
            gotoLink.innerHTML = "go to " + mode;

            $('.checky-bar').css({
                'position': 'fixed'
              , 'width': '450px'
              , 'font-size': '1.2em'
              , 'font-weight': 'bold'
              , 'background': color 
              , 'text-align': 'center'
              , 'left': '40%'
              , 'top': '23%'
              , 'z-index': '200'
              , 'padding': '5px'
              , 'border-radius': '12px'
              , 'margin': '2px 5px'
            }).html(mode + ": " + collection.length + (collection.length > 1 ? " feedbacks" : " feedback")).append(hideLink).append(gotoLink).show();

            $("#hide-checkybar").bind("click", function() {
                $(this).parents(".checky-bar").hide();
                if($(this).parents(".checky-bar").is(":hidden"))
                    location.reload(); 
            });

            $.ajax({
                type: "POST"      
              , data: {col: mode, feed_ids: collection, curl: currentUrl}
              , url: $(this).attr("hrefaction")
              , success: function(msg) {
                    /*
                    if(mode == 'restore') {
                        location.reload(); 
                    } 
                    */
                    checkFeed.attr('checked', false);
              }
            });
            collection.length = 0;     
        } else {
            collection.length = 0;     
        } 
    });
}

Checky.prototype.clickAll = function() { 
    var me = this;    
    $(me.click_all).bind('click', function(e) {
        if(this.checked) {
            $(me.check_feed_id).prop("checked", true);
            $(me.click_all).prop("checked", true);
        } else {
            $(me.check_feed_id).prop("checked", false);
            $(me.click_all).prop("checked", false);
        }                                            
    });
}
