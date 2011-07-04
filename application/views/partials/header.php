<html>
<html>
<head> 
	<title>36Stories - Get amazing feedback for your brand and business.</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <?=HTML::style('css/grid.css')?>
    <?=HTML::style('css/gridless.css')?>
</head>
<body>

<?
$user = new S36Auth;
if($user->check()):
?>
<div class="grids">
    <div>
    signed in as <?=$user->user()->username?>
    </div>
    <div class="g1of5">
        <ul>
            <li><?=HTML::link('dashboard/', 'Dashboard')?></li>
            <li><?=HTML::link('inbox/', 'Inbox')?></li>
            <li><?=HTML::link('featured/', 'Featured')?></li>
            <li><?=HTML::link('filed/', 'Filed Feedback')?></li>
            <li><?=HTML::link('feedsetup/', 'Feedback Setup')?></li>
            <li><?=HTML::link('contacts/', 'Contacts')?></li>
        </ul>
    </div>
<?endif?>
