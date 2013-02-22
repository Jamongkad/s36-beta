/*=========================================
||
|| JS File for the ThreeColumn Layout
||
||=========================================*/

var S36FullpageLayoutTreble = function(){
	/* ========================================
	|| Function needed to run by document ready
	==========================================*/
	this.init_fullpage_layout = function(common){
		common.init_masonry(275,12,750);
	}
	this.layout_name = "treble";
}