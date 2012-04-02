(function($){
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
			
			if($(this).attr('tooltip')){
				var text = $(this).attr('tooltip');
			}else{
				var text = options.text;
			}
			
			if($(this).attr('tt_width')){
				var width = $(this).attr('tt_width');
			}else{
				var width = options.width;
			}
			$(this).hover(
				function(){
					$(this).css({'cursor':'pointer'});
					$(this).parent().append('<span class="tooltip">'+text+'</span>');
					$(this).parent().find('span.tooltip').css({'top':top,'left':left,'width':width});
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