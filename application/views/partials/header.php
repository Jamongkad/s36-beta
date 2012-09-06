<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head> 
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="<?=URL::to('/')?>img/favicon.png">
	<title>36Stories - Get amazing feedback for your brand and business.</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <?=HTML::style('css/grid.css')?> 
        <?=HTML::style('css/romanticc.css')?>
        <?=HTML::style('css/admin.css')?>
        <?=HTML::style('css/zebra_pagination.css')?>
        <?=HTML::script('js/head.min.js')?>
        <?=HTML::script('js/jquery.tinymce.js')?>
        <?=HTML::script('js/jquery.cycle.all.min.js')?>
        <?
            $js_scripts = Array(
               '/js/jquery.switcharoo.js'
             , '/js/jquery.fancytips.js'
             , '/js/jquery.form.js'
             , '/js/jquery.tmpl.js'
             , '/js/jquery.jcrop.js'
             , '/js/jquery.ajaxfileupload.js'
             /*
             , '/js/jquery.ui.widget.js'
             , '/js/jquery.iframe-transport.js'
             , '/js/jquery.fileupload.js'
             */
             , '/js/jquery.zclip.js' 
             , '/js/jquery.flot.js'
             , '/js/jquery.flot.pie.js'
             , '/js/jquery.pjax.js'
             , '/js/jquery.timeago.js'
             , '/js/inbox/s36LightBox.js'
             , '/js/inbox/ZClip.js'
             , '/js/inbox/Checky.js'
             , '/js/inbox/DropDownChange.js'
             , '/js/inbox/InboxStatusChange.js'
             , '/js/inbox/InboxFilters.js'
             , '/js/inbox/FeedSetup.js'
             , '/js/inbox/Status.js'
             , '/js/inbox/s36application.js'
             , '/js/jquery.animate-colors-min.js'
             //, '/js/inbox/combined-min.js'
           );
           //$string = '"' . implode('","', $js_scripts) . '"';
       ?> 
        <script text="text/javascript">
            <?foreach($js_scripts as $scripts):?>
               head.js('<?=$scripts?>');
            <?endforeach?>
        </script>
    </meta>    
</head>
<body>

<?if(S36Auth::check()):?>
<?=Form::hidden('baseUrl', URL::to('/'))?>
<div id="admin-container">
    <div id="admin-panel">
		<div class="left-panel">
        	<div class="logo">
                <?=HTML::image('img/logo.jpg')?>
            </div>
            <div class="left-menu">
            	<ul id="nav-menu">
                    <? $regex = Helpers::nav_regex(); ?>
                    <li<?=($regex->dashboard ? ' class="selected dashboard"' : ' class="dashboard"')?>>
                        <?=HTML::link('dashboard', 'Dashboard')?>
                       <?=($regex->dashboard ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=($regex->inbox ? ' class="selected inbox"' :' class="inbox"')?>>
                        <?=HTML::link('inbox/all'.((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), 'Inbox')?>
                       <?=($regex->inbox ? '<div class="arrow-right"></div>' : null)?>
                       <?
                       $redis = new redisent\Redis;
                       $user_id = S36Auth::user()->userid;
                       $company_id = S36Auth::user()->companyid;
                       $checked = $redis->hget("user:$user_id:$company_id", "feedid_checked");

                       if($checked == 0):?> 
                           <?
                           $feedback = new Feedback\Repositories\DBFeedback;
                           $count = $feedback->total_newfeedback_by_company(); 
                           ?>
                           <sup class="count"><?=$count?></sup> 
                       <?else:?>
                           <sup></sup>
                       <?endif?>
                    </li>                 
                    <li<?=($regex->published ? ' class="selected published"' : ' class="published"')?>>
                        <?=HTML::link('inbox/published/all'.((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), 'Published')?>
                       <?=($regex->published ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <!--
                    <li<?=($regex->featured ? ' class="selected featured"' : ' class="featured"')?>>
                        <?=HTML::link('inbox/featured/all'.((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), 'Featured')?>
                       <?=($regex->featured ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    -->
                    <li<?=($regex->filed ? ' class="selected filed"' : ' class="filed"')?>>
                        <?=HTML::link('inbox/filed/all'.((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), 'Filed Feedback')?>
                       <?=($regex->filed ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=($regex->feedsetup ? ' class="selected setup"' : ' class="setup"')?>>
                        <?=HTML::link('feedsetup'.((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), 'Feedback Setup')?>
                       <?=($regex->feedsetup ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                    <li<?=($regex->contacts ? ' class="selected contacts"' : ' class="contacts"')?>>
                        <?=HTML::link('contacts', 'Contacts')?>
                       <?=($regex->contacts ? '<div class="arrow-right"></div>' : null)?>
                    </li>
                </ul>
            </div>
            <div class="left-buttons">
                <ul>
                    <li class="request"><?=HTML::link('/feedback/requestfeedback', 'Request Feedback')?></li>
                    <li class="add"><?=HTML::link('/feedback/addfeedback', 'Add Feedback')?></li>
                    <li class="delete"><?=HTML::link('/inbox/deleted/all', 'Deleted Feedback')?></li>
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
                     <?if($avatar = S36Auth::user()->avatar):?> 
                         <?=HTML::image('uploaded_cropped/48x48/'.$avatar)?>
                     <?else:?>
                         <?=HTML::image('img/48x48-blank-avatar.jpg')?>
                     <?endif?>
                </div>
                <div class="admin-details">
                    <div class="admin-signed-in">Signed in as <span><?=S36Auth::user()->username?></span></div>
                    <div class="admin-links">
                        <ul>
                            <li><?=HTML::link('admin', 'ADMIN', Array('class' => (Helpers::filter_highlighter(array('admin', 'admin/add_admin', 'admin/edit_admin')) ? 'selected' : null)))?></li>
                            <li><?=HTML::link('settings', 'SETTINGS', Array('class' => (Helpers::filter_highlighter(array('settings'
                                                                                                                        , 'settings/upgrade'
                                                                                                                        , 'settings/change_card'
                                                                                                                        , 'settings/cancel_account')) ? 'selected' : null)))?></li>
                            <li><a href="http://36stories.freshdesk.com/" target=_>HELP</a></li>
                        </ul>
                    </div>
                </div>
                <div class="admin-meta">
                    <div id="bye">
                        <?=HTML::link('logout', 'SIGN OUT')?>
                    </div>
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
                <?if($regex->inbox):?>
                    <div class="current-page inbox"> 
                        INBOX <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if($regex->published):?>
                    <div class="current-page published"> 
                        PUBLISHED <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <!--
                <?if($regex->featured):?>
                    <div class="current-page featured"> 
                        FEATURED 
                    </div>
                <?endif?>
                -->
                <?if($regex->filed):?>
                    <div class="current-page filed"> 
                        FILED <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if($regex->feedsetup):?>
                    <div class="current-page setup"> 
                        FEEDBACK SETUP <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if($regex->contacts):?>
                    <div class="current-page contacts"> 
                        CONTACTS <!--<span>There were 27 new feedback since your last visit.</span>--> 
                    </div>
                <?endif?>
                <?if($regex->admin):?>
                    <div class="current-page contacts"> 
                        ADMIN
                    </div>
                <?endif?>

                <?if(preg_match_all('/feedback\/requestfeedback/', Request::uri(), $matches)):?>
                    <div class="current-page request"> 
                        REQUEST FEEDBACK 
                    </div>
                <?endif?>

                <?if(preg_match_all('/feedback\/addfeedback/', Request::uri(), $matches)):?>
                    <div class="current-page setup"> 
                        ADD FEEDBACK 
                    </div>
                <?endif?>

                <?if(preg_match_all('/deleted/', Request::uri(), $matches)):?>
                    <div class="current-page trash"> 
                        DELETED 
                    </div>
                <?endif?>

                <?if(preg_match_all('/settings/', Request::uri(), $matches)):?>
                    <div class="current-page request"> 
                        SETTINGS
                    </div>
                <?endif?>

                <?if(preg_match_all('/reply_to/', Request::uri(), $matches)):?>
                    <div class="current-page contacts"> 
                        REPLY TO
                    </div>
                <?endif?>

                <?if(preg_match_all('/modifyfeedback/', Request::uri(), $matches)):?>
                    <div class="current-page contacts"> 
                        FEEDBACK INFORMATION
                    </div>
                <?endif?>
                <div class="checky-bar">&nbsp;</div>
            </div>
            <!-- end of gray status bar -->
            <?if(Request::route_is('inbox') 
                 //or Request::route_is('featured') 
                 or Request::route_is('filed') 
                 or Request::route_is('feedsetup') 
                 or Request::route_is('contacts')
                 or Request::route_is('settings')):?>
                    <?=View::make('partials/flag_menu')?>
            <?endif?>
<?endif?>
