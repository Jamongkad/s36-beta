<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36Module">
<head> 
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="<?=URL::to('/')?>img/favicon.png">
	<title>FDBack - Get amazing feedback for your brand and business.</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <?=HTML::script('/js/jquery.tinymce.js')?>
        <?=HTML::script('/js/jquery.cycle.all.min.js')?>
        
        <?=HTML::script('/js/helpers.js'); ?>
        <?=HTML::script('/admin_dashboard/dashboard.js'); ?>

        <?=HTML::script('/js/jquery.iframe-transport.js'); ?>
        <?=HTML::script('/js/jquery.fileupload.js'); ?>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>

        <?=HTML::script('/js/angular.compilehtml.js'); ?>

        <link rel="stylesheet" type="text/css" media="all "href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/jquery-ui.css" /> 

        <?=HTML::style('/fullpage/common/css/S36FullpageCommon.css')?> 
        <?=HTML::style('/fullpage/admin/css/S36FullpageAdmin.css')?> 
        <?=HTML::style('/css/respond.css')?>       
        <?=HTML::style('/fullpage/admin/css/dashboard.css')?>
        <?=HTML::style('/css/zebra_pagination.css')?>
        
    </meta>    
</head>
<body>

<?= View::make('hosted/partials/fullpage_bar_view'); ?>
<?= View::make('hosted/partials/fullpage_background_view'); ?>

<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer">
            
            <?= View::make('hosted/partials/fullpage_cover_view'); ?>

            <div id="theDashboard">
                    
                <?= View::make('partials/dashboard_menu'); ?>
                
                <div id="theDashboardContents">
