<?php
	$layout = "timeline"; //layout
	$as = false; 		  //set true to admin view
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36FullPageModule" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/master.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/flags.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/grids.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/override.css" />
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/css/<?php echo $layout ?>.layout.css" />

<script type="text/javascript" src="themes/hosted/fullpage/js/jquery.js"></script>
<script type="text/javascript" src="themes/hosted/fullpage/js/masonry.js"></script>
<script type="text/javascript" src="themes/hosted/fullpage/js/modernizr.js"></script>
<script type="text/javascript" src="themes/hosted/fullpage/js/infinitescroll.js"></script>
<script type="text/javascript" src="themes/hosted/fullpage/js/jquery-ui-1.8.24.custom.min.js"></script>
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/js/<?php echo $layout ?>.layout.js" />


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

		$('.feedbacks-list').masonry({
			itemSelector: '.feedback',
			columnWidth: 100,
			isAnimated: !Modernizr.csstransitions,
            gutterWidth: 365,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			}
		});

        add_branches();

	    var counter = 0;	
        function update() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
                counter += 1;
                var page_counter = counter + 1;
		        var container = $('#feedback-infinitescroll-landing'); 
                $.ajax({ 
                    url: '/hosted/fullpage_partial/' + page_counter
                  , success: function(msg) { 

                      var boxes = $(msg);
                      container.append(boxes);
                      reload_masonry();
                      twttr.widgets.load();
                      FB.XFBML.parse();
                    }
                });
		   }
		}
        //rate limit this bitch
        var throttled = _.throttle(update, 800);
		$(window).scroll(throttled);

	});

    //exclusive for timeline layout 
    function reload_masonry() {
        $('.left-branch, .right-branch').remove();
        $.when($('.feedback-list').masonry({
			itemSelector: '.feedback',
			columnWidth: 100,
			isAnimated: !Modernizr.csstransitions,
            gutterWidth: 365,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			}
		})).then(function() {
            add_branches();
        })
    }

    function add_branches(){ 
        var s = $('.feedback-list').find('.regular');
        $.each(s, function(i, obj){
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
</script>
