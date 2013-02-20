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
<?//= HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js'); ?>
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
echo HTML::script('/min/?g=Global.js');

/*
|--------------------------------------------------------------------------
| Fullpage Common
|--------------------------------------------------------------------------
*/
echo HTML::style('/min/?g=FullpageCommon.css');
echo HTML::script('/min/?g=FullpageCommon.js');

/*
|--------------------------------------------------------------------------
| Fullpage Admin
|--------------------------------------------------------------------------
*/
if( ! is_null(\S36Auth::user()) ):
echo HTML::style('/min/?g=FullpageAdmin.css');
echo HTML::script('/min/?g=FullpageAdmin.js');
echo HTML::script('/min/?g=QuickInbox.js');
endif;
?>
</head>
<body>
    
<div id="theBar">   
    <div id="theBarInner" class="clear">
        <div id="barLeftContent">
            <div class="barLinks clear">
                <div id="barImageLogo"><a href="#"><img src="/fullpage/common/img/36stories-logo.png" /></a></div>
                <?php if( is_null(\S36Auth::user()) ): ?>
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
                    <li><a href="#" id="admin_panel">Admin Panel</a></li>
                    <li><a href="/dashboard">My Dashboard</a></li>
                    <li><a href="/admin">My Account</a>
                        <ul>
                            <li><a href="/settings">My Settings</a>
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
