<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if(isset($_GET['nocache'])): ?>
    <meta http-equiv="expires" content="wed, 09 aug 2000 08:21:57 gmt" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <script type="text/javascript">
        window.location.href = window.location.pathname+window.location.hash;
    </script>
<?php endif; ?>
<?php
/*
|--------------------------------------------------------------------------
| Third-Party
|--------------------------------------------------------------------------
*/
?>
<?= HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'); ?>
<?= HTML::script('https://platform.twitter.com/widgets.js'); ?>
<?= HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.0.4/angular.min.js'); ?>
<?= HTML::script('https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js'); ?>

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
echo HTML::script('/minified/Global.js');

/*
|--------------------------------------------------------------------------
| Fullpage Common
|--------------------------------------------------------------------------
*/
echo HTML::script('/minified/FullpageCommon.js');
echo HTML::style('/minified/FullpageCommon.css');

/*
|--------------------------------------------------------------------------
| Fullpage Admin
|--------------------------------------------------------------------------
*/
if( ! is_null(\S36Auth::user()) ):
echo HTML::style('/minified/FullpageAdmin.css');
echo HTML::script('/minified/FullpageAdmin.js');
endif;
/*
|--------------------------------------------------------------------------
| FancyBox
|--------------------------------------------------------------------------
*/
echo HTML::script('/fancybox/jquery.fancybox.js');
echo HTML::script('/fancybox/jquery.fancybox.pack.js');
echo HTML::script('/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5');
echo HTML::script('/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5');
echo HTML::script('/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7');
echo HTML::style('/fancybox/jquery.fancybox.css');
echo HTML::style('/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5');
echo HTML::style('/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7');
?>
</head>
<body>
    
<div id="theBar">   
    <div id="theBarInner" class="clear">
        <div id="barLeftContent">
            <div class="barLinks clear">
                <div id="barImageLogo"><a href="http://beta.36stories.com/"><img src="/fullpage/common/img/36stories-logo.png" /></a></div>
                <?php if( is_null(\S36Auth::user()) ): ?>
                    <ul class="left-links">                 
                        <li><a href="http://beta.36stories.com/">Create Your Own Feedback Page!</a></li>
                    </ul>
                <?php endif ?>
            </div>
        </div>
        <div id="barRightContent">
            <div class="barLinks">
                <ul>
                    <?php if( ! is_null(\S36Auth::user()) ): ?>
                        <li><a href="#">Signed in as <span><?=\S36Auth::user()->username?></a></li>
                        <li><a href="#" id="admin_panel" initquick>Admin Panel</a></li>
                        <li><a href="/dashboard">My Dashboard</a></li>
                        <li><a href="/admin">My Account</a>
                            <ul>
                                <li><a href="/settings">My Settings</a></li>
                                <li><a href="http://36stories.freshdesk.com/">Help</a></li>
                                <li><?=HTML::link('logout?forward_to=me', 'Log Out')?></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li> 
                            <?=HTML::link('login?forward_to=me', 'Login')?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
