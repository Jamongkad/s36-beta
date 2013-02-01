<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36FullPageModule" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
/*
|--------------------------------------------------------------------------
| Third-Party
|--------------------------------------------------------------------------
*/
?>
<?= HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'); ?>
<?= HTML::script('https://platform.twitter.com/widgets.js" type="text/javascript'); ?>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<div id="fb-root"></div>
<script type="text/javascript">
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
<?php
/*
|--------------------------------------------------------------------------
| Global
|--------------------------------------------------------------------------
*/
?>
<?= HTML::script('/js/helpers.js'); ?>
<?= HTML::script('/js/jquery-ui-1.8.24.custom.min.js'); ?>
<?= HTML::script('/js/jquery.iframe-transport.js'); ?>
<?= HTML::script('/js/jquery.ui.widget.js'); ?>
<?= HTML::script('/js/jquery.raty.min.js'); ?>
<?= HTML::script('/js/jquery.fileupload.js'); ?>




<?php
/*
|--------------------------------------------------------------------------
| Fullpage Common
|--------------------------------------------------------------------------
*/
?>

<?= HTML::style('/fullpage/common/css/S36FullpageCommon.css'); ?>
<?= HTML::style('/fullpage/common/css/master.css'); ?>
<?= HTML::style('/fullpage/common/css/flags.css'); ?>
<?= HTML::style('/fullpage/common/css/grids.css'); ?>
<?= HTML::style('/fullpage/common/css/override.css'); ?>
<?= HTML::style('/fullpage/common/css/s36_client_style.css'); ?>

<?= HTML::script('/fullpage/common/js/S36FullpageCommon.js'); ?>
<?= HTML::script('/fullpage/common/js/masonry.js'); ?>
<?= HTML::script('/fullpage/common/js/modernizr.js'); ?>
<?= HTML::script('/fullpage/common/js/feedbackactions.js'); ?>
<?= HTML::script('/fullpage/common/js/s36_client_script.js'); ?>

<?php
/*
|--------------------------------------------------------------------------
| Fullpage Specific
|--------------------------------------------------------------------------
*/
?>
<?= HTML::style('/fullpage/layout/treble/css/S36FullpageLayoutTreble.css'); ?>
<?= HTML::script('/fullpage/layout/treble/js/S36FullpageLayoutTreble.js'); ?>
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
<?php
/*
|--------------------------------------------------------------------------
| Fullpage Admin
|--------------------------------------------------------------------------
*/
?>

<?php if( ! is_null(\S36Auth::user()) ): ?>
<?= HTML::style('/fullpage/admin/css/S36FullpageAdmin.css'); ?>
<?= HTML::style('/fullpage/admin/css/jcarousel.skin.css'); ?>
<?= HTML::style('/fullpage/admin/css/minicolors.css'); ?>

<?= HTML::script('/js/jquery.fileupload.js'); ?>
<?= HTML::script('/fullpage/admin/js/jcycle.js'); ?>
<?= HTML::script('/fullpage/admin/js/jquery.jcarousel.min.js'); ?>
<?= HTML::script('/fullpage/admin/js/minicolors.js'); ?>
<?= HTML::script('/fullpage/admin/js/colors.min.js'); ?>
<?= HTML::script('/fullpage/admin/js/S36FullpageAdmin.js'); ?>
<?php endif; ?> 
</head>
<body>
    
<div id="theBar">   
    <div id="theBarInner" class="clear">
        <div id="barLeftContent">
            <div class="barLinks clear">
                <div id="barImageLogo"><a href="#"><img src="/fullpage/common/img/36stories-logo.png" /></a></div>
                <?php if( ! is_null(\S36Auth::user()) ): ?>
                <ul class="left-links">                 
                    <li><a href="#">Create Your Own Feedback Page!</a></li>
                </ul>
                <?php endif ?>
            </div>
        </div>
        <div id="barRightContent">
            <div class="barLinks">
                <ul>
                    <?php if( ! is_null(\S36Auth::user()) ): ?>
                    <li><a href="/settings">My Settings</a></li>
                    <li><a href="/dashboard">My Dashboard</a></li>
                    <li><a href="/admin">My Account</a>
                        <ul>
                            <li><a href="/admin">Account Settings</a>
                            <li><a href="http://36stories.freshdesk.com/">Help</a>
                            <li><a href="/logout">Logout</a>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li><a href="/login">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
