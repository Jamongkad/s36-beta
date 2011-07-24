<html>
<html>
<head> 
	<title>36Stories - Get amazing feedback for your brand and business.</title>
    <?=HTML::script('js/jquery-1.6.2.min.js')?>
    <?=HTML::script('js/s36.js')?>
    <?=HTML::style('css/grid.css')?>
    <?//=HTML::style('css/gridless.css')?>
    <?=HTML::style('css/romanticc.css')?>
    <?=HTML::style('css/admin.css')?>
    <?=HTML::style('css/zebra_pagination.css')?>
    
</head>
<body>

<?
$user = new S36Auth;
if($user->check()):
?>

<div class="" id="admin-container">
    <div id="admin-panel">

		<div class="left-panel">
        	<div class="logo">
                <?=HTML::image('img/logo.jpg')?>
            </div>
            <div class="left-menu">
            	<ul id="nav-menu">
                    <li<?=(Request::uri() == 'dashboard' ? ' class="picked dashboard"' : ' class="dashboard"')?>>
                        <?=HTML::link('dashboard/', 'Dashboard')?>
                    </li>
                    <li<?=(Request::uri() == 'inbox' ? ' class="picked inbox"' :' class="inbox"')?>>
                        <?=HTML::link('inbox/', 'Inbox')?>
                    </li>
                    <li<?=(Request::uri() == 'published' ? ' class="picked published"' : ' class="published"')?>>
                        <?=HTML::link('published/', 'Published')?>
                    </li>
                    <li<?=(Request::uri() == 'featured' ? ' class="picked featured"' : ' class="featured"')?>>
                        <?=HTML::link('featured/', 'Featured')?>
                    </li>
                    <li<?=(Request::uri() == 'filed' ? ' class="picked filed"' : ' class="filed"')?>>
                        <?=HTML::link('filed/', 'Filed Feedback')?>
                    </li>
                    <li<?=(Request::uri() == 'feedsetup' ? ' class="picked setup"' : ' class="setup"')?>>
                        <?=HTML::link('feedsetup/', 'Feedback Setup')?>
                    </li>
                    <li<?=(Request::uri() == 'contacts' ? ' class="picked contacts"' : ' class="contacts"')?>>
                        <?=HTML::link('contacts/', 'Contacts')?>
                    </li>
                </ul>
            </div>
            <div class="left-block"></div>
        </div>
        <!-- end of the left panel -->

        <!--
        	The main panel
            All contents, session details, records will be displayed here.
        -->
        <div class="main-panel">
            <!-- start of the brown bar on the top -->
            <div class="admin-session-bar">
                <div class="admin-avatar">
                    <img src="images/sample-avatar.jpg" />
                </div>
                <div class="admin-details">
                    <div class="admin-signed-in">Signed in as <span><?=$user->user()->username?></span></div>
                    <div class="admin-links">
                        <ul>
                            <li><a href="#">ADMIN</a></li>
                            <li><a href="#">SETTINGS</a></li>
                            <li><a href="#">HELP</a></li>
                        </ul>
                    </div>
                </div>
                <div class="admin-meta">
                    <!-- 
                        drop down list on the top brown bar
                    -->
                    <? $site = DB::table('Site', 'master')->where('companyId', '=', $user->user()->companyid)->get(); ?>
                    <select name="site_choice">
                        <?foreach($site as $sites):?>
                            <option value="<?=$sites->siteid?>"><?=$sites->domain?></option>
                        <?endforeach?>
                    </select>
                    <?=HTML::link('logout/', 'SIGN OUT')?>
                </div>
            </div>
            <!-- end of the brown bar on the top -->

            <?if(Request::route_is('inbox') or Request::route_is('featured') or Request::route_is('filed')):?>
                    <?=View::make('partials/flag_menu')?>
            <?endif?>
<?endif?>
