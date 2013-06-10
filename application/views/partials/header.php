<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36Module">
<head> 
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="<?=URL::to('/')?>img/favicon.png">
	<title>FDBack - Get amazing feedback for your brand and business.</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
        <?=HTML::script('js/jquery.tinymce.js')?>
        <?=HTML::script('js/jquery.cycle.all.min.js')?>
        
        <?=HTML::script('/js/helpers.js'); ?>
        <?=HTML::script('/js/jquery.iframe-transport.js'); ?>
        <?=HTML::script('/js/jquery.fileupload.js'); ?>

        <link rel="stylesheet" type="text/css" media="all "href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css" />

       
        <?=HTML::style('fullpage/common/css/S36FullpageCommon.css')?> 
        <?=HTML::style('fullpage/admin/css/S36FullpageAdmin.css')?> 
        <?=HTML::style('css/respond.css')?>       
        <?=HTML::style('fullpage/admin/css/dashboard.css')?>
        <?=HTML::style('css/zebra_pagination.css')?>
        
    </meta>    
</head>
<body>

<script type="text/javascript">
    $(document).ready(function(){
        $('.action-delete').hover(function(){
            $(this).next().fadeIn('fast');
        },function(){
            $(this).next().fadeOut('fast');
        });
        $('.save').hover(function(){
            $(this).find('.the-categories-menu').fadeIn('fast');
        },function(){
            $(this).find('.the-categories-menu').fadeOut('fast');
        });
    });
    $(window).scroll(function() {
        
        var currentScroll = $('html').scrollTop() || $('body').scrollTop();
        if($(window).width() <= 600){
            top_margin = 270;
        }else{
            top_margin = 200;
        }
        $('.dashboard-feedback').each(function(){
            var top_offset = $(this).offset().top;
            var bot_offset = $(this).height() + top_offset - currentScroll;
            
            //console.log('element : ' + $(this).index() + ' | current :' +currentScroll + ' | top offset :' + top_offset + ' | bot_offset :' + bot_offset);
                
            var add_margin = 40 + currentScroll - top_offset;
            if((currentScroll >= top_offset) && (bot_offset >= top_margin)){
                console.log('boom!' + $(this).index());
                $(this).find('.feedback-action-menu').css('top',add_margin);
            }else{
                $(this).find('.feedback-action-menu').css('top',0); 
            }
        });
        
    });
</script>

<?= View::make('hosted/partials/fullpage_bar_view'); ?>
<?= View::make('hosted/partials/fullpage_background_view'); ?>

<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer">
            
            <?= View::make('hosted/partials/fullpage_cover_view'); ?>

            <div id="theDashboard">
                    
                <?= View::make('partials/dashboard_menu'); ?>
                
                <div id="theDashboardContents">
