<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36Module">
<head> 
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="<?=URL::to('/')?>img/favicon.png">
	<title>36Stories - Get amazing feedback for your brand and business.</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        <?=HTML::script('js/jquery.tinymce.js')?>
        <?=HTML::script('js/jquery.cycle.all.min.js')?>

        <link rel="stylesheet" type="text/css" media="all "href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css" />

        <?=HTML::style('css/grid.css')?> 
        <?=HTML::style('css/romanticc.css')?>
        <?=HTML::style('css/admin.css')?>
        <?=HTML::style('css/zebra_pagination.css')?>
        <?=HTML::style('css/jquery.formbuilder.css')?>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>

        <?=HTML::script('js/jquery.validate.js')?>
        <?=HTML::script('js/jquery.formbuilder.js')?>
        <?=HTML::script('js/jquery.ae.image.resize.min.js')?>

        <?=HTML::script('js/jquery.iframe-transport.js'); ?>
        <?=HTML::script('js/jquery.fileupload.js'); ?>

        <?=HTML::script('js/inbox/services/SettingsService.js')?>

        <?=HTML::script('js/inbox/directives/Components.js')?>
        <?=HTML::script('js/inbox/directives/myreply.js')?>
        <?=HTML::script('js/inbox/directives/myrequest.js')?>
        <?=HTML::script('js/inbox/directives/myfeedbackcount.js')?>
        <?=HTML::script('js/inbox/directives/myformbuilder.js')?>

        <?=HTML::script('js/inbox/controllers/SettingReplyCtrl.js')?>
        <?=HTML::script('js/inbox/controllers/requestctrl.js')?>
        <?=HTML::script('js/inbox/controllers/replyctrl.js')?>
        <?=HTML::script('js/inbox/controllers/feedbackcountctrl.js')?>

        <?=HTML::script('js/inbox/S36InboxModule.js')?>
        <?=HTML::script('js/jquery.flot.js')?>
        <?=HTML::script('js/jquery.flot.pie.js')?>

        <?=HTML::script('js/head.min.js')?>
        <?
            $js_scripts = Array(
               '/js/jquery.switcharoo.js'
             , '/js/jquery.fancytips.js'
             , '/js/jquery.form.js'
             , '/js/jquery.tmpl.js'
             , '/js/jquery.jcrop.js'
             , '/js/jquery.ajaxfileupload.js' 
             , '/js/jquery.zclip.js' 
             , '/js/jquery.zclip.js' 
             , '/js/inbox/s36LightBox.js'
             , '/js/inbox/ZClip.js'
             , '/js/inbox/Checky.js'
             , '/js/inbox/DropDownChange.js'
             , '/js/inbox/InboxStatusChange.js'
             , '/js/inbox/InboxFilters.js'
             , '/js/inbox/FeedSetup.js'
             , '/js/inbox/Status.js'
             , '/js/inbox/Settings.js'
             , '/js/inbox/s36application.js'
           );
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
                       //todo: ajaxify this use motherfuckin Angular mah nigguh
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

                       <span ng-controller="FeedbackCountCtrl">                    
                            <sup ng:class="get_class()"> 
                                {{display_count()}}
                            <sup>
                       </span>

                    </li>                 
                    <li<?=($regex->published ? ' class="selected published"' : ' class="published"')?>>
                        <?=HTML::link('inbox/published/all'.((Input::get('site_id')) ? '?site_id='.Input::get('site_id') : Null), 'Published')?>
                       <?=($regex->published ? '<div class="arrow-right"></div>' : null)?>
                    </li>
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
                    <li class="request" my-request><?=HTML::link('/feedback/requestfeedback', 'Request Feedback')?></li>
                    <li class="add"><?=HTML::link('/feedback/addfeedback', 'Add Feedback')?></li>
                    <li class="delete"><?=HTML::link('/inbox/deleted/all', 'Deleted Feedback')?></li>
                </ul>
            </div>

        </div>
        <!-- end of the left panel -->

        <!-- request feedback popup -->
        <div class="request-dialog" style="display:none">  
            <?=View::make('feedback/request_to_view')?>
        </div>
        <!-- end of request feedback popup -->

        <!-- Reply|Request Configuration Modal Window -->
        <?=View::make('feedback/partials/modal_message_configure');?>

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
