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
<script src="https://connect.facebook.net/en_US/all.js"></script>
</head>
<body>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
            // init the FB JS SDK
        FB.init({
            appId      : '<?=Config::get('application.fb_id');?>', // App ID from the App Dashboard
            status     : true, // check the login status upon init?
            cookie     : true, // set sessions cookies to allow your server to access the session?
            xfbml      : true  // parse XFBML tags on this page?
        });
    };

    (function(d, debug){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
        ref.parentNode.insertBefore(js, ref);
    }(document, /*debug*/ false))
</script>

<script type="text/javascript">
		
	$(document).ready(function(){

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
                                $(this).find('.feedback-branch').css({'left':'-30px','top':'40px'});
                            }
                            
                        });
                        twttr.widgets.load();
                        FB.XFBML.parse();
                    }
                });
		   }
		}
        //rate limit this bitch
        var throttled = _.throttle(update, 800);
		$(window).scroll(throttled);

        $('.feedback').each(function(){
            var leftOffset = $(this).css('left');
            
            if(leftOffset == '400px'){
                $(this).css('left','418px');
                $(this).find('.feedback-branch').css({'left':'-30px','top':'40px'});
            }
            
        });
		
		$('.twt-featured').each(function(){
			var nameContainer  = $(this).find('.feedbackAuthorDetails h2');
			var nameContent = nameContainer.html();
			var appendDash = '— '+nameContent;
			
			nameContainer.html(appendDash);
		});
	});
	/* end of document ready function. below are custom functions for this form */	
</script>
