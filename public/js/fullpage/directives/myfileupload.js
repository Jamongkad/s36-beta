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
                        make_cover_undraggable(false);
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
                console.log("Dirty Beats");
                e.preventDefault();
            });
        }
    }
})
//make_cover_undraggable(true);
function make_cover_undraggable(opt) {
    if(!opt) {
        console.log('Making Draggable');
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
                $(this).draggable({ containment: [-ipW, -ipH, offsetX, 0], scroll: false, disabled: opt});	
            });
        });
    } else {
        console.log('Draggable Disabled');
        $("#theCover img").draggable({disabled: true});
    }
}
