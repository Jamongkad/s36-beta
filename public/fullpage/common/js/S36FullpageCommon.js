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
		$('.uploaded-images-close').click(function(){
			$(this).parent().fadeOut('fast');
			$('.lightbox-shadow').fadeOut('fast');
		});
		$('.share-button').click(function(){
			$(this).find('.share-box').fadeToggle('fast');
		});
		$('.share-box').hover(function(){},function(){
			$(this).fadeOut('fast');
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
	|| Function needed for the top navigation bar
	==========================================*/
	this.init_toggle_bar = function(show){
		$('#theBarTab').click(function(){
			$('#theBar').slideToggle('fast');
			$(this).toggleClass('dropped');
			if(show == 1){
				$('#mainWrapper').animate({'top':'+=40'},'fast');
				show = 0;
			}else{
				$('#mainWrapper').animate({'top':'-=40'},'fast');
				show = 1;
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
			$('.left-branch').remove();
			$('.right-branch').remove();
			$.when($('.feedback-list').masonry()).then(function(){layout.add_branches()});
		}else if(layout_name == 'treble'){
			$('.feedback-list').masonry('reload');
		}else if(layout_name == 'traditional'){
			//no masonry!
		}
	}
}