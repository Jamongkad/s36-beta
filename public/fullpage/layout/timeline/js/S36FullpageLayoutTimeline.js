/*=========================================
||
|| JS File for the Timeline Layout
||
||=========================================*/
var S36FullpageLayoutTimeline = function(){
    var common = new S36FullpageCommon;
    /* ========================================
    || Function needed to run by document ready
    ==========================================*/
    this.init_fullpage_layout = function(){
        common.init_masonry(100,365,750);
        this.add_branches();
    }
    /* ========================================
    || This will apply the branches for every feedback on the timeline layout
    ==========================================*/
    this.add_branches = function(){ 
        var s = $('.feedback-list').find('.regular');
        $.each(s,function(i,obj){
            var posLeft = $(obj).css("left");
            if(posLeft == "0px"){
                html = "<span class='left-branch'></span>";
                $(obj).prepend(html); 
            }
            else{
                html = "<span class='right-branch'></span>";
                $(obj).prepend(html);
            }
        });
    }   
    this.layout_name = "timeline";
}
