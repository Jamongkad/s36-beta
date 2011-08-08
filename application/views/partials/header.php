<html>
<head> 
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>36Stories - Get amazing feedback for your brand and business.</title>
    <?=HTML::style('css/grid.css')?> 
    <?=HTML::style('css/romanticc.css')?>
    <?=HTML::style('css/admin.css')?>
    <?=HTML::style('css/zebra_pagination.css')?>
    </meta>    
</head>
<body>

<?if(S36Auth::check()):?>

<div class="" id="admin-container">
    <div id="admin-panel">
		<div class="left-panel">
        	<div class="logo">
                <?=HTML::image('img/logo.jpg')?>
            </div>
            <div class="left-menu">
            	<ul id="nav-menu">
                    <? $left_side_nav = Helpers::left_side_nav(); ?>
                    <li<?=($left_side_nav->dashboard ? ' class="selected dashboard"' : ' class="dashboard"')?>>
                        <?=HTML::link('dashboard/', 'Dashboard')?>
                       <?=($left_side_nav->dashboard ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=($left_side_nav->inbox ? ' class="selected inbox"' :' class="inbox"')?>>
                        <?=HTML::link('inbox/all/', 'Inbox')?>
                       <?=($left_side_nav->inbox ? '<div class="arrow-right"></div>' : null)?>
                    </li>                 
                    <li<?=($left_side_nav->published ? ' class="selected published"' : ' class="published"')?>>
                        <?=HTML::link('inbox/published/all', 'Published')?>
                       <?=($left_side_nav->published ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=($left_side_nav->featured ? ' class="selected featured"' : ' class="featured"')?>>
                        <?=HTML::link('inbox/featured/all', 'Featured')?>
                       <?=($left_side_nav->featured ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=($left_side_nav->profanity ? ' class="selected filed"' : ' class="filed"')?>>
                        <?=HTML::link('inbox/filed/all', 'Filed Feedback')?>
                       <?=($left_side_nav->profanity ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=($left_side_nav->feedsetup ? ' class="selected setup"' : ' class="setup"')?>>
                        <?=HTML::link('feedsetup', 'Feedback Setup')?>
                       <?=($left_side_nav->feedsetup ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=($left_side_nav->contacts ? ' class="selected contacts"' : ' class="contacts"')?>>
                        <?=HTML::link('contacts', 'Contacts')?>
                       <?=($left_side_nav->contacts ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                </ul>
            </div>
            <div class="left-buttons">
                <ul>
                    <li class="request"><?=HTML::link('/feedback/requestfeedback', 'Request Feedback')?></li>
                    <li class="add"><?=HTML::link('/feedback/addfeedback', 'Add Feedback')?></li>
                    <li class="delete"><?=HTML::link('/inbox/deleted', 'Deleted Feedback')?>

                    <?$feedback = new Feedback;
                      if($total_delete_feedback = $feedback->fetch_deleted_feedback()->total_rows):?>
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
                    <?=HTML::image('img/avatar-matthew.png')?>
                </div>
                <div class="admin-details">
                    <div class="admin-signed-in">Signed in as <span><?=S36Auth::user()->username?></span></div>
                    <div class="admin-links">
                        <ul>
                            <li><?=HTML::link('admin', 'ADMIN', Array('class' => (Helpers::filter_highlighter(array('admin')) ? 'selected' : null)))?></li>
                            <li><?=HTML::link('settings', 'SETTINGS', Array('class' => (Helpers::filter_highlighter(array('settings')) ? 'selected' : null)))?></li>
                            <li><?=HTML::link('help', 'HELP', Array('class' => (Helpers::filter_highlighter(array('help')) ? 'selected' : null)))?></li>
                        </ul>
                    </div>
                </div>
                <div class="admin-meta">
                    <!-- 
                        drop down list on the top brown bar
                    -->
                    <? $site = DB::table('Site', 'master')->where('companyId', '=', S36Auth::user()->companyid)->get(); ?>
                    <select name="site_choice">
                        <?foreach($site as $sites):?>
                            <option value="<?=$sites->siteid?>"><?=$sites->domain?></option>
                        <?endforeach?>
                    </select>
                    <?=HTML::link('logout/', 'SIGN OUT')?>
                </div>
            </div>
            <!-- end of the brown bar on the top -->

            <!-- gray status bar -->
            <div class="admin-status-bar">
                <?if(preg_match_all('/dashboard/', Request::uri(), $matches)):?>
                    <div class="current-page dashboard"> 
                        DASHBOARD <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if(preg_match_all('/inbox\/(all|profanity|flagged|mostcontent|[0-9]+)/', Request::uri(), $matches)):?>
                    <div class="current-page inbox"> 
                        INBOX <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if(preg_match_all('/published\/(all|profanity|flagged|mostcontent|[0-9]+)/', Request::uri(), $matches)):?>
                    <div class="current-page published"> 
                        PUBLISHED <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if(preg_match_all('/featured\/(all|profanity|flagged|mostcontent|[0-9]+)/', Request::uri(), $matches)):?>
                    <div class="current-page featured"> 
                        FEATURED <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if(preg_match_all('/filed\/(all|profanity|flagged|mostcontent|[0-9]+)/', Request::uri(), $matches)):?>
                    <div class="current-page filed"> 
                        FILED <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if(preg_match_all('/feedsetup/', Request::uri(), $matches)):?>
                    <div class="current-page setup"> 
                        FEEDBACK SETUP <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if(preg_match_all('/contacts/', Request::uri(), $matches)):?>
                    <div class="current-page contacts"> 
                        CONTACTS <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if(preg_match_all('/deleted/', Request::uri(), $matches)):?>
                    <div class="current-page trash"> 
                        DELETED FEEDBACK <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
            </div>
            <!-- end of gray status bar -->
            <?if(Request::route_is('inbox') or Request::route_is('featured') or Request::route_is('filed') or Request::route_is('feedsetup') or Request::route_is('contacts')):?>
                    <?=View::make('partials/flag_menu')?>
            <?endif?>
<?endif?>
