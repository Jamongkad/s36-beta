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
        
        <?if(preg_match('~hosted/form~', Request::uri())):?>
            <?=HTML::style('css/widget_master/hosted-form.css')?>
        <?endif?>

        <?if(preg_match('~hosted/single~', Request::uri())):?>
            <?=HTML::style('css/widget_master/hosted-single.css')?>
        <?endif?>

        <?=HTML::style('css/widget_master/form-default.css')?>
    </head>
<body>

