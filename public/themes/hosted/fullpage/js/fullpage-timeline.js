
$(document).ready(function(){

		$('.feedback').each(function(){
			var leftOffset = $(this).css('left');
			if(leftOffset == '400px'){
				$(this).css('left','418px');
				$(this).find('.feedback-branch').css({'left':'-31px','top':'40px'});
			}
		});
});
