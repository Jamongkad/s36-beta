(function($) {
$.fn.fancytips  = function(options) {
		var defaults = {
		text: 'tooltip',
		width: 100,
		top: 5,
		left: 0
		}
		var options = $.extend(defaults,  options);
		return this.each(function(){
			
			var left = $(this).position().left +options.left; 
			var top = $(this).height() +options.top;
			$(this).hover(
				function(){
					$(this).css({'cursor':'pointer'});
					$(this).parent().append('<span class="tooltip">'+options.text+'</span>');
					$(this).parent().find('span.tooltip').css({'top':top,'left':left,'width':options.width});
					$(this).parent().find('span.tooltip').fadeIn('fast');
				},
				function(){
					$('span.tooltip').fadeOut('fast',function(){
						$(this).removeClass('tooltip');
						$(this).remove();
					});
				}
				);
		});
	};
})(jQuery);
