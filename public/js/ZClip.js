function ZClip() {

    $('#widget-generate-view').zclip({
        path:'/js/ZeroClipboard.swf',
        copy:$('#widget-generate-view').val(),
        beforeCopy:function(){
            $(this).siblings('.copycheck').fadeIn();
        },
        afterCopy:function(){
            $(this).siblings('.copycheck').fadeOut(1000);
        }
    });
    $('#iframe-generate-view').zclip({
        path:'/js/ZeroClipboard.swf',
        copy:$('#iframe-generate-view').val(),
        beforeCopy:function(){
            $(this).siblings('.copycheck').fadeIn();
        },
        afterCopy:function(){
            $(this).siblings('.copycheck').fadeOut(1000);
        }
    });
}
