<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/1.7/jquery.min.js'></script>  
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

