jQuery(function($) {
    
    $("#preview-widget").bind("click", function(e) {
        var me = this;
        var embed_choices, iframe_code;
        var padding = 10;
        var embed_width  = $('input[name="embed_width"]').val() > 0 ? parseInt($('input[name="embed_width"]').val(), 10) + padding : 750;
        var embed_height = $('input[name="embed_height"]').val() > 0 ? parseInt($('input[name="embed_height"]').val(), 10) + padding : 440;
        var site_id      = $('input[name="site_id"]').val() > 0 ? $('input[name="site_id"]').val() : $('select[name="site_id"]').val();
        var embed_type = $("input:radio[name='embed_type']:checked").val();
        var company_id = $("input[name='company_id']").val();
        var theme_id = $("input:radio[name='theme_id']:checked").val();
        var embed_choices;

        embed_choices = embed_choice_check(embed_type);

        $.ajax({
            url: $(me).attr('hrefaction')
          , data: "siteId=" + site_id + "&companyId=" + company_id + "&themeId=" + theme_id + "&embed_type=" + embed_type + embed_choices
          , dataType: 'html'
          , success : function(msg) {
              s36Lightbox(embed_width, embed_height, msg); 
          }
        });
     
        
    });
    
    $("#horizontal_embed, #vertical_embed").bind('click', function() {
        var click_type = $(this).attr('id');

        if(click_type == 'horizontal_embed') {
            set_height_width(600, 300);
        }

        if(click_type == 'vertical_embed') {
            set_height_width(250, 500);
        }

        function set_height_width(x, y) {
            $('input[name="embed_width"]').val(x);
            $('input[name="embed_height"]').val(y);  
        }

    });

    $("#generate-feedback-btn").bind("click", function(e) {
        var me = this;
        var site_id = $("input[name='site_id']").val() ? $("input[name='site_id']").val() : $("select[name='site_id']").val();
        var company_id = $("input[name='company_id']").val();
        var embed_type = $("input:radio[name='embed_type']:checked").val();
        var theme_id = $("input:radio[name='theme_id']:checked").val();
        var embed_choices;

        embed_choices = embed_choice_check(embed_type);

        $.ajax({
            url: $(me).attr('hrefaction')
          , data: "getJSON=1&siteId=" + site_id + "&companyId=" + company_id + "&themeId=" + theme_id + "&embed_type=" + embed_type + embed_choices
          , dataType: 'json'
          , success : function(msg) {
              $("#code-generate-view").val(msg.init_code);             
              $("#widget-generate-view").val(msg.widget_code);
          }
        });

        e.preventDefault();
    })

    $('a.get-code').bind('click', function(e) {  
        var url = $(this).attr('href');  
        $.ajax({
            url: url
          , success : function(msg) {
              s36Lightbox(500, 420, msg);
          }
        });
        return e.preventDefault();  
    });

    $('input[type="button"].widget-edit, input[type="button"].widget-delete').bind('click', function(e) {


        var hrefaction = $(this).attr('hrefaction');
        var input_class = $(this).attr('class');
        var input_parents = $(this).parents('tr');
        var ajax_action;

        if(input_class == 'widget-delete') {
            if(confirm("Are you sure you want to delete this theme?")) {
                input_parents.fadeOut(400);     
                $.post(hrefaction, function(msg) { console.log(msg); });           
            }
        } 

        if(input_class == 'widget-edit') {
            $.getJSON(hrefaction, function(msg) { s36Lightbox(msg.width, msg.height, msg.view); });                
        }
         
        e.preventDefault();

    });

    //helper functions
    function embed_choice_check(embed_type) {

        var embed_choice_string;

        if(embed_type == 'fullpage') {
            embed_choice_string = "&units=" + $('select[name="full_page_units"] option:selected').val();
        }

        if(embed_type == 'embedded') {
            embed_choice_string = "&type=" + $('input[name="embed_block_type"]:checked').val() + "&width=" + $('input[name="embed_width"]').val() + "&height=" + $('input[name="embed_height"]').val();
            embed_choice_string += "&effect=" + $('select[name="embed_effects"] option:selected').val() + "&units=" + $('select[name="embed_units"] option:selected').val();
        }

        if(embed_type == 'modal') {
            embed_choice_string = "&effect=" + $('select[name="modal_effects"] option:selected').val();
        }

        if(!embed_choice_string) { 
            alert("Please choose a Widget.");
            return false;
        }

        return embed_choice_string; 
    }

    function s36Lightbox(width, height, insertContent) {	
        if($('#lightbox').size() == 0){
            var theLightbox = $('<div id="lightbox"/>');
            var theShadow = $('<div id="lightbox-shadow"/>');
            $(theShadow).click(function(e){
                closeLightbox();
            });
            $('body').append(theShadow);
            $('body').append(theLightbox);
        }
        $('#lightbox').empty();
        if(insertContent != null){
            $('#lightbox').append(insertContent);
        }
        
        //set negative margin for dynamic width
        var margin = Math.round(width / 2);
        
        // set the css and show the lightbox
        $('#lightbox').css('top', $(window).scrollTop() + 100 + 'px');
        $('#lightbox').css({
                            'width':width,
                            'height':height,
                            'margin-left':"-"+margin+"px"
                            });
                            
        $('#lightbox').fadeIn('fast');
        $('#lightbox-shadow').fadeIn('fast');
    }

    function closeLightbox(){
        $('#lightbox').fadeOut('fast',function(){$(this).empty();});
        $('#lightbox-shadow').fadeOut('fast');
    }    
})
