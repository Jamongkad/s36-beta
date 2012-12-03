<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/master.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/flags.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/grids.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.24.custom.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.24/jquery.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script>!window.jQuery && document.write('<script src="https://code.jquery.com/jquery-1.4.2.min.js"><\/script>');</script>
-->
<script type="text/javascript" src="js/masonry.js"></script>
<script type="text/javascript" src="js/modernizr.js"></script>
<script type="text/javascript" src="js/jquery.ajaxfileupload.js"></script>
<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
<script type="text/javascript">
		
	$(document).ready(function(){

		$('.feedback').each(function(){
			var leftOffset = $(this).css('left');
			
			if(leftOffset == '400px'){
				$(this).css('left','418px');
				$(this).find('.feedback-branch').css({'left':'-23px','top':'40px'});
			}
			
		});


		$('.the-feedbacks').masonry({
			itemSelector: '.feedback',
			columnWidth: 100,
			isAnimated: !Modernizr.csstransitions,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			  }
		});
		$('#twitterFeedbacks').masonry({
			itemSelector: '.feedback',
			columnWidth: 100,
			isAnimated: !Modernizr.csstransitions,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			  }
		});
		
		$(window).scroll(function() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
				/*add_boxes();		 */
		   }
		});
		
		$('.feedback').hover(function(){
		    $(this).find('.feedbackSocialTwitter').fadeIn();
			$(this).find('.feedbackSocialFacebook').fadeIn();
		},function(){
			$(this).find('.feedbackSocialTwitter').fadeOut();
			$(this).find('.feedbackSocialFacebook').fadeOut();
		});

		// New scripts for the Logo Upload Oct 4 2012
		make_cover_undraggable(true);
		$('#changeCoverButton').hide();
		$('#pageCover').mouseover(function(){
			if($('#saveCoverButton').css('display')=='none'){
				$('#changeCoverButton').show();
			}
		});
		$('#pageCover').mouseout(function(){
			$('#changeCoverButton').hide();
		});

		$('#changeCoverButton').click(function(){
			trigger_file_upload();
		});
		
		$('#changeCoverButton').mousemove(function(e){
			$('#logoUpload').css('left',e.clientX-5);
			$('#logoUpload').css('top' ,e.clientY-5);
			$('#logoUpload').css('cursor','pointer');
		});
		
		$('#saveCoverButton').click(function(){
			var src = $('#theCover img');
			var data = {
				src : src.attr('src'),
				top : src.offset().top,
				left: '0'
			}
			
			upload_to_server(data);
		});
		// end of new scripts
		$('.twt-featured').each(function(){
			var nameContainer  = $(this).find('.feedbackAuthorDetails h2');
			var nameContent = nameContainer.html();
			var appendDash = '— '+nameContent;
			
			nameContainer.html(appendDash);
		});
	});
	/* end of document ready function. below are custom functions for this form */	
	
	// New Functions for the Logo Upload Oct 4 2012
	function make_cover_undraggable(opt){
		if(!opt){
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
		}else{
			$("#theCover img").draggable({disabled: true});
		}
	}
	function trigger_file_upload(){
		console.log('File Upload Initialize!');
		//document.getElementById('logoUpload').click();
	}
	function upload_new_logo(){
		ajax_file_upload();
	}
	function upload_to_server(data){
		/*save data to database*/
        $.ajax({
            url: "savecoverphoto",
            type: "POST",
            data: data,
            success: function(q) {
                console.log(q);
          }
        });
	
		$('#saveCoverButton').html('Cover Saved');
		var timeout;
		if(timeout) {
			clearTimeout(timeout);
			timeout = null;
		}
		timeout = setTimeout(hide_save_button, 1000);
	}
	
	function hide_save_button(){
		$('#saveCoverButton').fadeOut('fast',function(){
			$(this).html('Save Cover');
		});
		$('#changeCoverButton').fadeIn('fast');
		$('#dragPhoto').fadeOut('fast');
		make_cover_undraggable(true);
	}
	
	function ajax_file_upload()
	{
		//starting setting some animation when the ajax starts and completes
		$('#changeCoverButton #changeButtonText').html('Uploading...');
		$.ajaxFileUpload
		(
			{
				url:'imageprocessing/upload_coverphoto',
				type:'POST',
				secureuri:false,
				fileElementId:'logoUpload',
				dataType: 'json',
				success: function (data, status)
				{	
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							$('#changeCoverButton #changeButtonText').html(data.error + ' Click to Choose Files Again' );
							console.log(data.error);
							return false;
						}else
						{
							fetch_new_image(data.msg);
							change_logo(data.msg);
						}
					}
					
				},
				error: function (data, status, e)
				{
					return false;
				}
			}
		)
	}  
	
	
	function change_logo(src){
		$('#coverPhoto').attr('src',src);
	}
	
	function fetch_new_image(src){
	    $('#changeCoverButton #changeButtonText').html('Crunching Image...');
		$('<img />')
			.attr('src', src)
			.load(function() {
				$('#changeCoverButton').fadeOut('fast',function(){
					$(this).find('#changeButtonText').html('Change Cover');
					$('#dragPhoto').fadeIn('fast');
					$('#saveCoverButton').fadeIn('fast');
				});
		});
		make_cover_undraggable(false);
	}
	// end of new functions
	
	
 
 function loadSocialButtons(id,target){
		
		var link = 'http://www.36stories.com/stand-alone/'+id;
		
		if(target.find('.twitter-button').length == 0){
			target.append(
						$('<div />').addClass('twitter-button')
									.append('<a href="'+link+'" class="twitter-share-button">Tweet</a>'))
				  .append(
						$('<div />').addClass('facebook-button')
									.append('<lo><iframe src="//www.facebook.com/plugins/like.php?href='+link+'&amp;send=false&amp;layout=buwaltton_count&amp;width=450&a</lo>mp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>')
				  );
			
			twttr.widgets.load(); // parse the twitter widgets
			FB.XFBML.parse();	  // parse the facebook widgets
		}
		target.slideToggle('fast');
	}

</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

</head>

<body>
