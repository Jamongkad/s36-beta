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
                    <li<?=(Request::uri() == 'dashboard' ? ' class="selected dashboard"' : ' class="dashboard"')?>>
                        <?=HTML::link('dashboard/', 'Dashboard')?>
                       <?=(Request::uri() == 'dashboard' ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=(preg_match('/inbox/', Request::uri()) ? ' class="selected inbox"' :' class="inbox"')?>>
                        <?=HTML::link('inbox/', 'Inbox')?>
                       <?=(preg_match('/inbox/', Request::uri()) ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=(Request::uri() == 'published' ? ' class="selected published"' : ' class="published"')?>>
                        <?=HTML::link('published/', 'Published')?>
                       <?=(Request::uri() == 'published' ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=(Request::uri() == 'featured' ? ' class="selected featured"' : ' class="featured"')?>>
                        <?=HTML::link('featured/', 'Featured')?>
                       <?=(Request::uri() == 'featured' ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=(Request::uri() == 'filed' ? ' class="selected filed"' : ' class="filed"')?>>
                        <?=HTML::link('filed/', 'Filed Feedback')?>
                       <?=(Request::uri() == 'filed' ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=(Request::uri() == 'feedsetup' ? ' class="selected setup"' : ' class="setup"')?>>
                        <?=HTML::link('feedsetup/', 'Feedback Setup')?>
                       <?=(Request::uri() == 'feedsetup' ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=(Request::uri() == 'contacts' ? ' class="selected contacts"' : ' class="contacts"')?>>
                        <?=HTML::link('contacts/', 'Contacts')?>
                       <?=(Request::uri() == 'contacts' ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                </ul>
            </div>

            <div class="left-buttons">
                <ul>
                    <li class="request"><?=HTML::link('/feedback/requestfeedback', 'Request Feedback')?></li>
                    <li class="add"><?=HTML::link('/feedback/addfeedback', 'Add Feedback')?></li>
                    <li class="delete"><?=HTML::link('/feedback/deletedfeedback', 'Deleted Feedback')?>

                    <?$feedback = new Feedback
                      if($total_delete_feedback = $feedback->fetched_deleted_feedback()->total_rows):?>
                          <sup class="count"><?=$total_delete_feedback?></sup> 
                    <?else:?>
                          <sup></sup>
                    <?endif?>
                    </li>
                </ul>
            </div>

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
