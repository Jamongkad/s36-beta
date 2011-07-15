<html>
<html>
<head> 
	<title>36Stories - Get amazing feedback for your brand and business.</title>
    <?=HTML::script('js/jquery-1.6.2.min.js')?>
    <?=HTML::script('js/s36.js')?>
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
            <li<?=(Request::uri() == 'dashboard' ? ' class="picked"' : null)?>><?=HTML::link('dashboard/', 'Dashboard')?></li>
            <li<?=(Request::uri() == 'inbox' ? ' class="picked"' : null)?>><?=HTML::link('inbox/', 'Inbox')?></li>
            <li<?=(Request::uri() == 'featured' ? ' class="picked"' : null)?>><?=HTML::link('featured/', 'Featured')?></li>
            <li<?=(Request::uri() == 'filed' ? ' class="picked"' : null)?>><?=HTML::link('filed/', 'Filed Feedback')?></li>
            <li<?=(Request::uri() == 'feedsetup' ? ' class="picked"' : null)?>><?=HTML::link('feedsetup/', 'Feedback Setup')?></li>
            <li<?=(Request::uri() == 'contacts' ? ' class="picked"' : null)?>><?=HTML::link('contacts/', 'Contacts')?></li>
        </ul>
    </div>

    <?if(Request::route_is('inbox') or Request::route_is('featured') or Request::route_is('filed')):?>
        <?=View::make('partials/flag_menu')?>
    <?endif?>

<?endif?>
