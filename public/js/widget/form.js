jQuery(function($) {
    
    //hide what to write, error message
    $('#s36_whattowrite').hide();
    //$('#s36_error').hide();
    
    $('#s36_tip').click(function(){
        $('#s36_whattowrite').slideToggle();
    });
    
    $('#loading').hide();
    $('#feedback_permission').hide();
    $('#prev').hide();
    $('.error-message').hide();
    
    /*
    $('#feedback_text').tinymce({
        script_url : '<?=URL::to('/')?>js/tiny_mce.js',
        mode : "textareas",
        theme_advanced_font_sizes : "12px,14px,16px,18px,24px"
    });
    */ 
    // toggle class for each list items
    $('#leave_fb'). click(function(){ $(this).parent().find('li').removeClass(); $(this).addClass('active'); });
    $('#browse_fb').click(function(){ $(this).parent().find('li').removeClass(); $(this).addClass('active'); });

    // initiate the cycle script for the #steps div
    var $steps = $('#steps').cycle({  fx: 'fade', speed: 100, timeout: 0, before: S36Form.assign_class });	
    
    // move to the manual form if the user doesn't want to connect to facebook:
    $('#create_wo_facebook').click(function(){ $steps.cycle(3); $('#next').show(); });
    
    // when clicking the next button
    $('#next').click(function(){
            var next = new PageCycle().cycle_next();
            if(next)			//if returned true, then cycle the form to the next ui
            hide_error();		//hide errors
            $steps.cycle(next);	//cycle
        });
    $('#prev').click(function(){
            var prev = new PageCycle().cycle_prev();
            if(prev)			//if returned true, then cycle the form to the prev ui
            hide_error();		//hide errors
            $steps.cycle(prev);	//cycle
        });
        
    // assign crop script to crop btn
    $('#crop_photo').hide();
    $('#cancel_cropbtn').hide();
    $('#cancel_cropbtn').click(function(){
        $steps.cycle(5);
        S36Form.hide_crop_buttons();
    });
    // added
    // assign crop script to crop btn
    $('#cropbtn').hide();
    $('#cropbtn').click(function(){        
        var crop_success = S36Form.save_crop_image();
        if( crop_success.statusText == 'success' ){
            $steps.cycle(5);
            // hide the crop btn						
            S36Form.hide_crop_buttons();
        } 
    });
    //end added
    // start the rating slider
    S36Form.start_slider();

    $('#edit-review-feedback').click(function(){S36Form.edit_feedback()});
    $('#save-edited-feedback').hide();
    $('#save-edited-feedback').click(function(){S36Form.save_edited_feedback()});
    
    S36Form.default_text(); 
    console.log(S36Form);
});
