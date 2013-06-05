/*=========================================
||
|| Master JS File for all Fullpage Layout
||
||=========================================*/
var S36FullpageCommon = function(){
	/* ========================================
	|| Function needed to run by document ready
	==========================================*/
	this.init_fullpage_common = function(){
		$('.feedback-icon').hover(function(){
			$(this).find('.icon-tooltip').fadeIn('fast');
		},function(){
			$(this).find('.icon-tooltip').fadeOut('fast');
		});
		$('#fullpage_desc.editable').click(function(){
			$('#desc_hint').hide();
			$('#fullpage_desc_textbox').show().focus();
			$('#fullpage_desc_textbox').val( Helpers.entities2html( Helpers.br2nl($(this).html().replace(/\n/g,'')) ) );
			$(this).hide();
		});
		$('#fullpage_desc_textbox').blur(function(){
			$('#fullpage_desc_textbox').attr('disabled', 'disabled');
			
			$.ajax({
				async: false,
		        url: '/update_desc',
		        type: 'post',
		        data: {description : $('#fullpage_desc_textbox').val()},
		        success: function(result){
		        	if( $.trim(result) != '' ){
	                    Helpers.display_error_mes( [result] );
	                }
		        }
		    });
		    
		    // delay this to avoid multiple saving.
		    setTimeout(function(){
		    	var desc_textbox = $('#fullpage_desc_textbox');
		    	if( $.trim(desc_textbox.val()) == '' ) $('#desc_hint').show();
				$('#fullpage_desc').fadeIn();
				$('#fullpage_desc').html( Helpers.nl2br( Helpers.html2entities(desc_textbox.val()) ) );
				if( $('.companyDescription').length ){
					$('.companyDescription').html( Helpers.nl2br( Helpers.html2entities(desc_textbox.val()) ) );
				}
				desc_textbox.removeAttr('disabled');
				desc_textbox.hide();
		    }, 800);
		});
		
		if( window.innerHeight < 700 ) $('#s36_modalbox').css({'margin-top': '30px', 'top' : '0px'});
		
		$('.uploaded-images-close').click(function(){
			$(this).parent().fadeOut('fast');
			$('.lightbox-shadow').fadeOut('fast');
		});
		$('.share-button').click(function(){
			//$(this).find('.share-box').fadeToggle('fast');
			//$(this).find('.share-box').toggle();
		});
		$('.share-box').hover(function(){},function(){
			//$(this).fadeOut('fast');
		});
	}
	/* ========================================
	|| This function will initialize the masonry for every layout
	==========================================*/
	this.init_masonry = function(width,gutWidth,duration){		
		$('.feedback-list').masonry({
			itemSelector: '.feedback',
			columnWidth: width,
			gutterWidth: gutWidth,
			isAnimated: true,
			animationOptions: {
				duration: duration,
				easing: 'linear',
				queue: false
			  }
		});
	}
	/* ========================================
	|| Function needed to close the lightbox
	==========================================*/
	this.close_lightbox = function(){
		$('.lightbox-s').fadeOut('fast');
		$('#lightboxNotification').fadeOut('fast');
		return 0;
	}
	/* ========================================
	|| Function needed to display an error message
	==========================================*/
	this.display_error_mes = function(mes){
		$('.lightbox-message').addClass('error');
		$('.lightbox-message ul').html('').each(function(){
			$.each(mes,function(e,str){
				$('.lightbox-message ul').append('<li>'+str+'</li>');	
			});
		});
		this.display_lightbox();
	}
	/* ========================================
	|| Function needed to display a lightbox
	==========================================*/
	this.display_lightbox = function(){
		$('#lightbox').fadeIn();
		$('#lightbox-s').fadeIn();
		return false;
	}
	/* ========================================
	|| Function needed to reload the masonry by providing the current layout name
	|| current available layouts: traditional, timeline, threeColumn
	==========================================*/
	this.reload_layout_masonry = function(layout){
		var layout_name = layout.layout_name;
		if(layout_name == 'timeline'){
			//$('.left-branch').remove();
			//$('.right-branch').remove();
			$.when($('#feedback-infinitescroll-landing').find('.feedback-list').masonry()).then(function(){layout.add_branches()});
		}else if(layout_name == 'treble'){
			$('.feedback-list').masonry('reload');
			this.init_masonry(275,12,750);
		}else if(layout_name == 'traditional'){
			//no masonry!
		}
	}
	
	
	// create a fullpage layout object.
	this.create_layout = function(layout){
		layout = layout.toLowerCase();
		
		if( layout == 'traditional' ) return new S36FullpageLayoutTraditional();
		if( layout == 'timeline' ) return new S36FullpageLayoutTimeline();
		if( layout == 'treble' ) return new S36FullpageLayoutTreble();
	}

    this.init_quick_inbox = function() {
        console.log("Initializing Quick Inbox");
        var pane = $('.widget-list').jScrollPane();
        var api = pane.data('jsp');
        api.destroy();
        setTimeout(function() {
            $('.widget-list').jScrollPane();
        }, 200); 
    }
}
