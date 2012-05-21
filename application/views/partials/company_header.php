<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>

        <?=HTML::script('js/head.min.js')?>
        <?=HTML::style('css/widget_master/flags_widget.css')?>
        <?=HTML::style('css/widget_master/grids.css')?>
        
        <?  
            preg_match_all('~hosted/(form|single|fullpage)~', Request::uri(), $matches);
            //YUCK!! 
            $hosted_type = array_slice($matches, 1);
            if($hosted_type[0][0] == 'single') {
                echo HTML::style('css/widget_master/hosted-single.css');
            }

            if($hosted_type[0][0] == 'form') {
                echo HTML::style('css/widget_master/hosted-form.css');
            }

            if($hosted_type[0][0] == 'fullpage') {
                echo HTML::style('css/widget_master/hosted-fullpage.css');
            }
        ?>

        <?=HTML::style('css/widget_master/form-default.css')?>
    </head>
<body>
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
