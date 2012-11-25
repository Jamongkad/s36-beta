<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36FullPageModule" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/master.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/flags.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/grids.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/masonry.js"></script>
<script type="text/javascript" src="js/modernizr.js"></script>

<!--new ajax file upload plugin -->
<script type="text/javascript" src="js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery.fileupload.js"></script>
<!--new ajax file upload plugin -->

<script src="https://platform.twitter.com/widgets.js" type="text/javascript"></script>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?=Config::get('application.fb_id');?>";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript">
		
	$(document).ready(function(){

        //twttr.widgets.load(); // parse the twitter widgets
        //FB.XFBML.parse();	  // parse the facebook widgets
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

	    var counter = 0;	
        function update() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
                counter += 1;
                var page_counter = counter + 1;
		        var container = $('#feedback-landing'); 
                $.ajax({ 
                    url: '/hosted/fullpage_partial/' + page_counter
                  , success: function(msg) { 
                        var boxes = $(msg);
                        container.append(boxes);
                        boxes.children('.the-feedbacks').masonry({ 
                            itemSelector: '.feedback',
                            columnWidth: 100,
                            isAnimated: !Modernizr.csstransitions,
                            animationOptions: {
                                duration: 750,
                                easing: 'linear',
                                queue: false
                            } 
                        })
                        $('.feedback').each(function(){
                            var leftOffset = $(this).css('left');
                            
                            if(leftOffset == '400px'){
                                $(this).css('left','418px');
                                $(this).find('.feedback-branch').css({'left':'-23px','top':'40px'});
                            }
                            
                        });
   
                        twttr.widgets.load(); // parse the twitter widgets
                        FB.XFBML.parse();	  // parse the facebook widgets 
                    }
                });
		   }
		}
        //rate limit this bitch
        var throttled = _.throttle(update, 800);
		$(window).scroll(throttled);
		
		$('.twt-featured').each(function(){
			var nameContainer  = $(this).find('.feedbackAuthorDetails h2');
			var nameContent = nameContainer.html();
			var appendDash = '— '+nameContent;
			
			nameContainer.html(appendDash);
		});
	});
	/* end of document ready function. below are custom functions for this form */	
/*	
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
*/
</script>
</head>
<body>
<div id="fb-root"></div>
