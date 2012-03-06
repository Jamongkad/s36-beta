/*
 * Submission Form Widget Controller
 */

jQuery(function($) {    
    // start the rating slider
    S36Form.start_slider();
    S36Form.default_text();  

    //hide what to write, error message
    $('#s36_whattowrite').hide();
    
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
    // initiate the cycle script for the #steps div
    var $steps = $('#steps').cycle({  fx: 'fade', speed: 100, timeout: 0, before: S36Form.assign_class });	
    
    // move to the manual form if the user doesn't want to connect to facebook:
    $('#s36_create_profile').click(function(e) { 
        $steps.cycle(3); $('#next').show(); 
        S36Form.s36_connect_success();
        e.preventDefault();
    });
    
    // when clicking the next button
    $('#next').click(function(){
        var next = new PageCycle().cycle_next();
        if(next)			//if returned true, then cycle the form to the next ui
            S36Form.hide_error();		//hide errors
            $steps.cycle(next);	//cycle
    });
    $('#prev').click(function(){
        var prev = new PageCycle().cycle_prev();
        if(prev)			//if returned true, then cycle the form to the prev ui
            S36Form.hide_error();		//hide errors
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
    $('#cropbtn').click(function(e){          
        S36Form.save_crop_image();
        e.preventDefault();
    });
    //end added
    $('#edit-review-feedback').click(function(){S36Form.edit_feedback()});
    $('#save-edited-feedback').hide();
    $('#save-edited-feedback').click(function(){S36Form.save_edited_feedback()});
});
