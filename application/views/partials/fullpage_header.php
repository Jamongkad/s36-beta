<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36FullPageModule" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://platform.twitter.com/widgets.js" type="text/javascript"></script>
<script src="https://connect.facebook.net/en_US/all.js"></script>

<?= HTML::style('/fullpage/common/css/master.css'); ?>
<?= HTML::style('/fullpage/common/css/flags.css'); ?>
<?= HTML::style('/fullpage/common/css/grids.css'); ?>
<?= HTML::style('/fullpage/common/css/override.css'); ?>
<?= HTML::style('/fullpage/common/css/s36_client_style.css'); ?>
<?= HTML::style('/fullpage/layout/timeline/css/S36FullpageLayoutTimeline.css'); ?>

<?= HTML::script('/js/helpers.js'); ?>
<?= HTML::script('/js/jquery.iframe-transport.js'); ?>
<?= HTML::script('/js/jquery.ui.widget.js'); ?>
<?= HTML::script('/js/jquery.fileupload.js'); ?>
<?= HTML::script('/js/jquery-ui-1.8.24.custom.min.js'); ?>
<?= HTML::script('/js/jquery.raty.min.js'); ?>

<?= HTML::script('/fullpage/common/js/masonry.js'); ?>
<?= HTML::script('/fullpage/common/js/modernizr.js'); ?>
<?= HTML::script('/fullpage/common/js/feedbackactions.js'); ?>
<?= HTML::script('/fullpage/common/js/s36_client_script.js'); ?>

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

        S36FeedbackActions.initialize_actions();
    
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
                      S36FeedbackActions.initialize_actions();
                    }
                });
		   }
		}
        //rate limit this bitch
        var throttled = _.throttle(update, 800);
		$(window).scroll(throttled);
	});
</script>
