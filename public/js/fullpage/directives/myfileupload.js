angular.module('fileupload', [])
.directive('myFileupload', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).fileupload({
                dataType: 'json'
              , change: function(e, data) {
 		            $('#changeCoverButton #changeButtonText').html('Uploading...');                       
                }
              , success: function(data) { 
	                $('#changeCoverButton #changeButtonText').html('Crunching Image...');

                    if(data.error) {      
                        $('#changeCoverButton #changeButtonText').html(data.error + ' Click to Choose File Again' );
                    } else { 

                        $('#coverPhoto').attr('src', data.msg);
                        $('#defaultCoverPhoto').remove();
                         
                        $('<img />')
                            .attr('src', data.msg)
                            .load(function() {
                                $('#changeCoverButton').fadeOut('fast',function(){
                                    $(this).find('#changeButtonText').html('Change Cover');
                                    $('#dragPhoto').fadeIn('fast');
                                    $('#saveCoverButton').fadeIn('fast');
                                });
                            });
                        activate_drag();
                    }
                }
            });
        }
    }    
})
.directive('saveMyupload', function() {
    return {
        restrict: 'A'     
      , link: function(scope, element, attrs) {
            $(element).bind('click', function(e) {

                var cover_src = $('#theCover img');
                var img_src_attrs = {
                    src : cover_src.attr('src')
                  , top : cover_src.offset().top
                  , left: 0
                }	
                
                $.ajax({
                    url: "/imageprocessing/savecoverphoto",
                    type: "POST",
                    dataType: "JSON",
                    data: img_src_attrs,
                    success: function(res) {
     		            $(element).html('Cover Saved');
                        
                        var timeout;

                        if(timeout) {
                            clearTimeout(timeout);
                            timeout = null;
                        }

                        timeout = setTimeout(hide_save_button, 1000); 
                        deactivate_drag();
                    }
                });

                e.preventDefault();
            });
        }
    }
})

function activate_drag(flag) {
    console.log('Draggable Enabled');
    $("#theCover img").load(function(){	
        var offset = $(this).parent().offset();
        var offsetX = offset.left;
        $(this).each(function(){ 
            var imgH = $(this).height();
            var parH = $(this).parent().height();
            var imgW = $(this).width();
            var parW = $(this).parent().width();  
            var ipH = imgH-parH;
            var ipW = imgW-parW-offsetX;			
            $(this).draggable({ containment: [-ipW, -ipH, offsetX, 0], scroll: false, disabled: false});	
        });
    });

}

function deactivate_drag() { 
    console.log('Draggable Disabled');
    $("#theCover img").draggable({disabled: true});
}

function hide_save_button(){
    $('#saveCoverButton').fadeOut('fast',function(){
        $(this).html('Save Cover');
    });
    $('#changeCoverButton').fadeIn('fast');
    $('#dragPhoto').fadeOut('fast');
}

$('#changeCoverButton').hide();
$('#pageCover').mouseover(function(){
    if($('#saveCoverButton').css('display')=='none'){
        $('#changeCoverButton').show();
    }
});

$('#pageCover').mouseout(function(){
    $('#changeCoverButton').hide();
});

$('#changeCoverButton').mousemove(function(e){
    $('#logoUpload').css('left', e.clientX - 5);
    $('#logoUpload').css('top' , e.clientY - 5);
    $('#logoUpload').css('cursor','pointer');
});
