<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html ng-app="S36Module">
<head> 
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="<?=URL::to('/')?>img/favicon.png">
	<title>36Stories - Get amazing feedback for your brand and business.</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        <?=HTML::script('js/jquery.tinymce.js')?>
        <?=HTML::script('js/jquery.cycle.all.min.js')?>

        <link rel="stylesheet" type="text/css" media="all "href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/base/jquery-ui.css" />

        <?=HTML::style('css/grid.css')?> 
        <?=HTML::style('css/romanticc.css')?>
        <?=HTML::style('css/admin.css')?>
        <?=HTML::style('css/zebra_pagination.css')?>

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
        <?=Form::open('feedback/requestfeedback', 'POST', array('id' => 'requestForm'))?>
            <div  id="reply-box" >
                <div class="reply-box-styles">
                    <h2>Request Feedback</h2>
                    <div class="reply-box-content">
                    <span>
                    Drop a request to someone you want to get feedback from. You can write your own custom message, or use one of our template messages. The recipient will receive a custom email with a link to send in their feedback with. 
                    </span>
                    
                    <br />
                    <br />
                    <div class="reply-box-form">
                        <h3>Recepient Details</h3>
                            <div>
                                <table width="80%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="130">
                                        <label>First Name : </label>
                                        </td>
                                        <td>
                                        <input type="text" name="first_name" class="regular-text" id="recipient-fname" value=""/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <label>Last Name : </label>
                                        </td>
                                        <td>
                                        <input type="text" name="last_name" class="regular-text" id="recipient-lname" value=""/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <label>Email : </label>
                                        </td>
                                        <td>
                                        <input type="text" name="email" class="regular-text" id="recipient-email" value=""/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <label>Message : </label> <br />
                                        </td>
                                        <td>
                                        <textarea class="regular-text" name="message" style="float:left" rows="7" id="message" ></textarea>
                                        <?
                                            $sm = new Message\Services\SettingMessage('rqs');       
                                            $reply_message = $sm->get_messages();
                                        ?>
                                        <ul class="custom-message">   
                                            <?if($reply_message):?>
                                                <?foreach($reply_message as $val):?>
                                                    <li id="<?=$val->id?>"><a href="#"><?=$val->text?></a></li>
                                                <?endforeach?>
                                            <?endif?>
                                        </ul>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="reply-box-padding"></div>
                    <!--
                    <div class="reply-box-error">
                           <div class="reply-box-text">
                           </div>
                    </div>
                    -->
                    <div class="reply-box-footer">
                        <div class="reply-box-buttons">
                            <input type="button" class="large-btn" value="Cancel" />
                            <input type="button" class="large-btn" value="Send" />
                        </div>
                    </div>
                </div>
                <!-- end of reply-box styles -->
            </div>
        <!-- end of reply-box -->
        <?=Form::close()?>
        </div>
        <!-- end of request feedback popup -->

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
