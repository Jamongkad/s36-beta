<html>
<html>
<head> 
	<title>36Stories - Get amazing feedback for your brand and business.</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <?=HTML::style('css/grid.css')?>
    <?=HTML::style('css/gridless.css')?>
    <?=HTML::style('css/romanticc.css')?>
</head>
<body>

<?
$user = new S36Auth;
if($user->check()):
?>
<div class="grids">
    <div id="nav_holder">
        signed in as <b><?=$user->user()->username?></b>
        <ul class="nav">
            <li><?=HTML::link('admin/', 'Admin')?></li>
            <li><?=HTML::link('settings/', 'Settings')?></li>
            <li><?=HTML::link('help/', 'Help')?></li>
            <li><?=HTML::link('logout/', 'Logout')?></li>
        </ul>
    </div>
    <div class="g1of5 dash_holder">
        <ul class="dash_nav">
            <li><?=HTML::link('dashboard/', 'Dashboard')?></li>
            <li><?=HTML::link('inbox/', 'Inbox')?></li>
            <li><?=HTML::link('featured/', 'Featured')?></li>
            <li><?=HTML::link('filed/', 'Filed Feedback')?></li>
            <li><?=HTML::link('feedsetup/', 'Feedback Setup')?></li>
            <li><?=HTML::link('contacts/', 'Contacts')?></li>
        </ul>
    </div>
    <?=View::make('partials/flag_menu')?>
<?endif?>
