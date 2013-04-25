/*=========================================
||
|| Master JS File for Hosted Form
||
||=========================================*/
var S36HostedForm = function(){
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
}