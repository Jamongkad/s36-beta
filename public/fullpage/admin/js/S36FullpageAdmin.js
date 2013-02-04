// JavaScript Document

/*=========================================
||
|| JS File for the Admin View
|| Date: 01/03/2013
|| Version: 0.0.0.1 
|| 
||=========================================*/

var S36FullpageAdmin = function(layoutObj){
	/* ========================================
	|| Function needed to run by document ready
	==========================================*/
	var self = this;
	var common = new S36FullpageCommon;
	this.init_fullpage_admin = function(){
		/* ========================================
		|| Make the admin window box draggable
		==========================================*/
		$('#adminWindowBox').draggable({ handle: '#adminWindowTitleBar',opacity:0.5});
		/* ========================================
		|| Close the admin window box when close button is clicked
		==========================================*/
		$('#adminWindowTitleBar .closeBtn').click(function(){
			$('#adminWindowBox').fadeOut('fast');
		});
		/* ========================================
		|| Minimize the admin window when minimize button is clicked
		==========================================*/
		var minClick = 1;
		$('#adminWindowTitleBar .minBtn').click(function(){
			$('#adminWindowHolder').slideToggle('fast');
			if(minClick == 1){
				$(this).addClass('maxBtn');
				minClick = 0;
			}else{
				$(this).removeClass('maxBtn');
				minClick = 1;
			}
		});
		/* ========================================
		|| Change the background color
		==========================================*/
		$('.backgroundColorPicker').on('change',function(){
			self.change_background_color($(this).val(),$(this).attr('data-opacity'));
		});
		/* ========================================
		|| Change the button color
		==========================================*/		
		$('.btnBgColor').on('change',function(){
			self.change_button_color($(this).val());
		});
		/* ========================================
		|| Change the mouseover background color
		==========================================*/		
		$('.mbtnBgColor').on('change',function(){
			self.change_mouseover_button_color($(this).val());
		});
		/* ========================================
		|| Change the font of the mouse button color
		==========================================*/		
		$('.btnFontColor').on('change',function(){
			self.change_button_font_color($(this).val());
		});
		/* ========================================
		|| Apply the jcarousel plugin for the patterns
		==========================================*/		
		$('#patterns').jcarousel({
			scroll: 5,
			initCallback: function(){},
			buttonNextHTML: '#patternPrev',
			buttonPrevHTML: '#patternNext'
		});
		/* ========================================
		|| Change this pattern's active state when a pattern is clicked
		==========================================*/		
		$('.patternItem').click(function(){
			$('.patternItem.active').removeClass('active');
			$(this).addClass('active');
			self.apply_pattern_design($(this).attr('id'));
		});
		/* ========================================
		|| Create pages for the admin window for each links
		==========================================*/
		var $adminPage = $('#adminWindowPages').cycle({
			fx: 'fade', speed: 100, timeout: 0, before: self.adjust_window_height
		});
		/* ========================================
		|| Transition the current panel of the admin window when a tab is clicked
		==========================================*/
		$('#adminWindowMenuBar ul li').click(function(){
			$('#adminWindowMenuBar ul li .active').removeClass('active');
			$(this).find('a').addClass('active');
			var index = $(this).index();
			$adminPage.cycle(index);
		});
		/* ========================================
		|| Apply the fileupload plugin for the background image
		==========================================*/
		$('#bg_image').fileupload({
			dropZone: '#bgDragBox',
			dataType: 'json',
			add: function(e, data){
				var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
				if( image_types.indexOf( data.files[0].type ) == -1 ){
					var error = ['Please select an image file'];
					self.display_error_mes(error);
					return false;
				}
				if( data.files[0].size > 2000000 ){
					var error = ['Please upload an image that is less than 2mb'];
					self.display_error_mes(error);
					return false;
				}
				data.submit();
			},progress: function(e, data){
				self.show_notification('Uploading Background Image',0);
			},done: function(e, data){
				self.change_background_image(data.result[0].url);
				self.hide_notification();
			}
		});
		/* ========================================
		|| Apply the fileupload plugin for the cover photo
		==========================================*/
		$('#cv_image').fileupload({
			dataType: 'json',
			add: function(e, data){
				var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
				if( image_types.indexOf( data.files[0].type ) == -1 ){
					var error = ['Please select an image file'];
					self.display_error_mes(error);
					return false;
				}
				if( data.files[0].size > 2000000 ){
					var error = ['Changing cover image..'];
					self.display_error_mes(error);
					return false;
				}
				data.submit();
			},progress: function(e, data){
				self.show_notification('Changing Cover Photo',0);
			},done: function(e, data){
				self.change_cover_image(data.result[0].url);
			}
		});
		/* ========================================
		|| Display option tickerbox active state toggler
		==========================================*/
		$('.tickerbox').click(function(){
			var classes = $(this).attr('display-array');
			self.hide_element(classes);			
			$(this).toggleClass('off');
		});
		/* ========================================
		|| Background position toggler
		==========================================*/
		$('.bgPos').click(function(){
			$('.bgPos.active').removeClass('active');
			$(this).addClass('active');
		});
		/* ========================================
		|| Background repeat toggler
		==========================================*/
		$('.bgRepeat').click(function(){
			$('.bgRepeat.active').removeClass('active');
			$(this).addClass('active');
		});
		/* ========================================
		|| Background position change to left
		==========================================*/
		$('#bg_pos_l').click(function(){
			self.change_background_position('left');
		});
		/* ========================================
		|| Background position change to center
		==========================================*/
		$('#bg_pos_c').click(function(){
			self.change_background_position('center');
		});
		/* ========================================
		|| Background position change to right
		==========================================*/
		$('#bg_pos_r').click(function(){
			self.change_background_position('right');
		});
		/* ========================================
		|| Background position change to top
		==========================================*/
		$('#bg_pos_t').click(function(){
			self.change_background_position('top');
		});
		/* ========================================
		|| Background position change to bottom
		==========================================*/
		$('#bg_pos_b').click(function(){
			self.change_background_position('bottom');
		});
		/* ========================================
		|| Background repeat change to repeat
		==========================================*/
		$('#bg_repeat_r').click(function(){
			self.change_background_repeat('repeat');
		});
		/* ========================================
		|| Background repeat change to no-repeat
		==========================================*/
		$('#bg_repeat_nr').click(function(){
			self.change_background_repeat('no-repeat');
		});
		/* ========================================
		|| Background repeat change to repeat-x
		==========================================*/
		$('#bg_repeat_rh').click(function(){
			self.change_background_repeat('repeat-x');
		});
		/* ========================================
		|| Background repeat change to repeat-y
		==========================================*/
		$('#bg_repeat_rv').click(function(){
			self.change_background_repeat('repeat-y');
		});
		/* ========================================
		|| When the cover button is saved, use this function to update the database
		==========================================*/
		$('#saveCoverButton').click(function(){
			self.upload_to_server();
		});
		/* ========================================
		|| By Default, the bar toggle switch will have a dropped class. (When admin is logged in)
		==========================================*/
		$('#theBarTab').addClass('dropped');
		/* ========================================
		|| Display the bar by default
		==========================================*/
		$('#theBar').show();
	}
	/* ========================================
	|| Pattern change function
	==========================================*/
	this.apply_pattern_design = function(filename){
		$('body').css('background-image','url(fullpage/common/img/patterns/'+filename+')');
	}
	/* ========================================
	|| Background Image Changer, supply the path
	==========================================*/
	this.change_background_image = function(path){
		$('body').css('background-image','url('+path+')');
		$('#bodyColorOverlay').css('opacity',0);
	}
	/* ========================================
	|| Cover Image changer
	==========================================*/
	this.change_cover_image = function(path){
		$('<img />')
			.attr('src', path)
			.load(function(e){
				self.make_cover_undraggable(false);
				$('#coverPhoto img').attr({'src':path,width:'100%'});
				$('#saveCoverButton').show();
				$('#changeCoverButton').hide();
				self.hide_notification();
		});	
	}
	/* ========================================
	|| Background repeat attribute changer
	==========================================*/
	this.change_background_repeat = function(rules){
		$('body').css('background-repeat',rules);
	}
	/* ========================================
	|| Background position attribute changer
	==========================================*/
	this.change_background_position = function(pos){
		$('body').css('background-position',pos);
	}
	/* ========================================
	|| Button Font Color Changer
	==========================================*/
	this.change_button_font_color = function(hex){
		var elem = $('.send-button a');
		elem.css({'color':hex});	
	}
	/* ========================================
	|| Button Background Color Changer
	==========================================*/
	this.change_button_color = function(hex){
		var elem = $('.send-button a');
		elem.css({'background-color':hex});	
	}
	/* ========================================
	|| Button Mouseover Bg color Changer. Trust me no other script will work other than this
	==========================================*/
	this.change_mouseover_button_color = function(hex){
		var elem = $('.send-button a');
		elem.hover(function(){
			$(this).css({'background-color':hex});	
		},function(){
			var althex = $('.btnBgColor').val();
			$(this).css({'background-color':althex});	
		});
	}
	/* ========================================
	|| Background Color and Opacity Changer
	==========================================*/
	this.change_background_color = function(hex,opc){
		var elem = $('#bodyColorOverlay');
		elem.css({'background-color':hex,'opacity':opc});
	}
	/* ========================================
	|| Adjust the admin window height depending on the elements inside
	==========================================*/
	this.adjust_window_height = function(curr, next, opts, fwd) {
		var $ht = $(this).height();
		$(this).parent().animate({"height":$ht},'fast');
	}
	/* ========================================
	|| Display an awesome notification, mes = messages in array, delay = integer in millisecond
	==========================================*/
	this.show_notification = function(mes,delay){
		var delay = delay;
		$('#notification-message').empty().html(mes);
		$('#notification').animate({ height: '50', opacity: '100' }, 'fast','',function(){
			if(delay){
				setTimeout(this.hide_notification,delay);		
			}
		});
	}
	/* ========================================
	|| Hide the Notification
	==========================================*/
	this.hide_notification = function(){
		$("#notification").animate({ height: 0, opacity: 0 }, 'fast');
	}
	/* ========================================
	|| Hide an element using its class
	==========================================*/
	this.hide_element = function(elem){
		var classes = elem.split(',');
		$.each(classes,function(index,value){
			$('.'+value).toggle();
		});
		common.reload_layout_masonry(layoutObj);
	}
	/* ========================================
	|| Make the cover undraggable by passing a true paramater
	==========================================*/
	this.make_cover_undraggable = function(opt){
		if(!opt){
			$("#coverPhoto img").load(function(){
				$('#dragPhoto').fadeIn();
				var offset = $(this).parent().offset();
				var offsetX = offset.left;
				$(this).each(function(){
					var imgH = $(this).height();
					var parH = $(this).parent().height();
					var imgW = $(this).width();
					var parW = $(this).parent().width();  
					var ipH = imgH-parH;
					var ipW = imgW-parW-offsetX;
					$(this).draggable({ containment: [-ipW, -ipH, offsetX, 0], scroll: false, disabled: opt});
				});
			});
		}else{
			$('#dragPhoto').fadeOut();
			$("#coverPhoto img").draggable({disabled: true});
		}
	}
	/* ========================================
	|| Upload to server function you do this shit roberto
	==========================================*/
	this.upload_to_server = function(data){
		/* pass the variables from here to the database then initialize the codes below if upload to db is successful */
		$('#saveCoverButton').html('Cover Saved');
		var timeout;
		if(timeout) {
			clearTimeout(timeout);
			timeout = null;
		}
		timeout = setTimeout(this.hide_save_button, 1000);
	}
	/* ========================================
	|| Hide the save button when clicked
	==========================================*/
	this.hide_save_button = function(){
		$('#saveCoverButton').fadeOut('fast',function(){
			$(this).html('Save Cover');
		});
		$('#changeCoverButton').fadeIn('fast');
		$('#dragPhoto').fadeOut('fast');
		self.make_cover_undraggable(true);
	}

}


