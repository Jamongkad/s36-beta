<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36Module">
<head> 
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"></meta>
	<title>FDBack - Get amazing feedback for your brand and business.</title>
        <link rel="stylesheet" type="text/css" media="all "href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css" />
        <link rel="shortcut icon" href="<?=URL::to('/')?>img/favicon.png">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

        <?=HTML::script('/minified/Global.js')?>
        <?=HTML::style('/minified/Global.css')?>

        <?=HTML::script('/minified/FullpageAdmin.js')?>
        
        <?=HTML::style('/fullpage/admin/css/S36FullpageAdmin.css')?> 
        <?=HTML::style('/fullpage/admin/css/jcarousel.skin.css')?>
        <?=HTML::style('/fullpage/admin/css/minicolors.css')?>
        <?=HTML::style('/fullpage/admin/css/dashboard.css')?>

        <?=HTML::style('/fullpage/common/css/S36FullpageCommon.css')?> 
        <?=HTML::style('/css/respond.css')?>       
        

</head>
<body>

<div id="notification">
    <div id="notification-design">
        <div id="notification-message">
            Loading... Please Wait...
        </div>
    </div>
</div>

<?= View::make('hosted/partials/fullpage_bar_view'); ?>
<?= View::make('hosted/partials/fullpage_background_view'); ?>

<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer">
            
            <?= View::make('hosted/partials/fullpage_cover_view'); ?>

            <div id="theDashboard">
                    
                <?= View::make('partials/dashboard_menu'); ?>
                
                <div id="theDashboardContents">
