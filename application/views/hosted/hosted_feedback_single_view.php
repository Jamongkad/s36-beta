<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#" style="height: auto;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?=URL::to('/')?>img/favicon.png">
<?php if(isset($_GET['nocache'])): ?>
    <meta http-equiv="expires" content="wed, 09 aug 2000 08:21:57 gmt" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <script type="text/javascript">
        window.location.href = window.location.pathname+window.location.hash;
    </script>
<?php endif; ?>
<?php
/*
|--------------------------------------------------------------------------
| Third-Party
|--------------------------------------------------------------------------
*/
?>
<?= HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'); ?>
<?= HTML::script('https://platform.twitter.com/widgets.js'); ?>
<?= HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.0.4/angular.min.js'); ?>
<?= HTML::script('https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js'); ?>
<!--[if lt IE 9]>
<script src="https://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->

<?php
/*
|--------------------------------------------------------------------------
| Global
|--------------------------------------------------------------------------
*/
echo HTML::script('/minified/Global.js');

/*
|--------------------------------------------------------------------------
| Fullpage Common
|--------------------------------------------------------------------------
*/
echo HTML::script('/minified/FullpageCommon.js');
echo HTML::style('/minified/FullpageCommon.css');
echo HTML::style('/css/respond.css');  // has a bug when minified.

/*
|--------------------------------------------------------------------------
| Fullpage Admin
|--------------------------------------------------------------------------
*/
if( ! is_null(\S36Auth::user()) ):
echo HTML::style('/minified/FullpageAdmin.css');
echo HTML::script('/minified/FullpageAdmin.js');
endif;
/*
|--------------------------------------------------------------------------
| FancyBox
|--------------------------------------------------------------------------
*/
echo HTML::script('/fancybox/jquery.fancybox.js');
echo HTML::script('/fancybox/jquery.fancybox.pack.js');
echo HTML::script('/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5');
echo HTML::script('/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5');
echo HTML::script('/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7');
echo HTML::style('/fancybox/jquery.fancybox.css');
echo HTML::style('/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5');
echo HTML::style('/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7');

$comp = DB::table('Company')
    ->left_join('HostedSettings', 'Company.companyId', '=', 'HostedSettings.companyId')
    ->where('Company.name', '=', Config::get('application.subdomain'))
    ->first(array(
        'Company.name',
        'HostedSettings.description AS description',
        'Company.coverphoto_src AS image',
        'Company.logo AS logo'
    ));

$title          = ucfirst($comp->name) . '\'s Customer Feedback & Reviews page';
$description    = (trim($comp->description) != '' ? $comp->description : 'Welcome to ' . ucfirst($comp->name) . '\'s customer feedback and reviews page. Feel free to leave a rating for us!');
$app_url        = Config::get('application.url');
$url            = Config::get('application.url').$_SERVER['REQUEST_URI'];
$logo           = ( empty($comp->logo) ? $app_url.'/img/public-profile-pic.jpg' : $app_url.'/uploaded_images/company_logos/main/' . $comp->logo );
?>
<title><?php echo $title; ?></title>
<meta property="og:title" content="<?php echo $title; ?>">
<meta property="og:description" content="<?php echo $description; ?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo $logo; ?>">
<meta property="og:url" content="<?php echo $url; ?>">
<meta property="fb:app_id" content="<?=Config::get('application.fb_id');?>">
</head>
<body style="height: 100%;">
<script src="https://connect.facebook.net/en_US/all.js"></script>
<div id="fb-root"></div>
<script type="text/javascript">
    window.fbAsyncInit = function() {
            // init the FB JS SDK
        FB.init({
            appId      : '<?=Config::get('application.fb_id');?>', // App ID from the App Dashboard
            status     : true, // check the login status upon init?
            cookie     : true, // set sessions cookies to allow your server to access the session?
            xfbml      : true  // parse XFBML tags on this page?
        });
    };

    (function(d, debug){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
        ref.parentNode.insertBefore(js, ref);
    }(document, /*debug*/ false))
</script>

<?= View::make('hosted/partials/fullpage_bar_view'); ?>
<?= View::make('hosted/partials/fullpage_background_view'); ?>

<div id="mainWrapper" style="height: 100%;">
    <div id="fadedContainer" style="height: 100%;">
        <div id="mainContainer">
            
            <!-- the arrow pointer -->
            <div id="thePointer"></div>
            <!-- end of pointer -->
            
            <?= View::make('hosted/partials/fullpage_cover_view'); ?>
            <?= View::make('hosted/partials/fullpage_company_summary_view', array('company' => $company, 'widget_loader' => $widget_loader, 'user' => $user)); ?>
            
            
            <?php
            $feedback_id                = $feedback->id;
            $tw_marker                  = ($feedback->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
            $avatar                     = Config::get('application.avatar48_dir').'/'.$feedback->avatar;
            $avatar                     = Helpers::avatar_render($feedback->avatar, $feedback->origin);
            $attachments                = (!empty($feedback->attachments)) ? $feedback->attachments : false;
            $vote_count                 = $feedback->vote_count;
            $voted                      = $feedback->useful;
            $flagged                    = $feedback->flagged_as_inappr;
            $metadata                   = $feedback->metadata;
            $is_recommended             = $feedback->isrecommended;
            $position                   = $feedback->position;
            $company_name               = $feedback->companyname;
            $city                       = $feedback->city;
            $country_name               = $feedback->countryname;
            $admin_avatar               = ($feedback->admin_avatar) ? '/uploaded_images/admin_avatar/' . $feedback->admin_avatar : '/img/48x48-blank-avatar.jpg';
            $admin_companyname          = ($feedback->admin_fullpagecompanyname) ? $feedback->admin_fullpagecompanyname : $feedback->companyname;
            ?>
            <div id="feedbackContainer">
                <!-- this is where the magic begins -->
                <div id="threeColumnLayout"> 
                    <div class="feedback-spine" style="height: auto; bottom: 35px;"></div>
                    <div class="spine-spacer"></div>
                    <div class="feedback-date"></div>
                    <div class="spine-spacer"></div>
                    <script type="text/javascript">
                        <? // hack to hide the first .feedback-date and show the first .spine-spacer. ?>
                        $('.feedback-date:first').css('display', 'none');
                        $('.spine-spacer:first').css({'display' : 'block', 'height' : '20px'});
                    </script>
                    <div class="feedback-list">
                        <div class="feedback regular-featured" fid="<?=$feedback_id;?>">
                            <?=$tw_marker?>
                            <div class="regular-featured-contents">
                                <!-- feedback header -->
                                <div class="feedback-header clear">
                                    <div class="author">
                                        <div class="author-avatar"><img src="<?=$avatar?>" width="100%"/></div>  
                                        <div class="author-information">
                                            <div class="author-name break-word clear">                                            
                                                <span class="first_name"><?= HTML::entities($feedback->firstname); ?></span>
                                                <span class="last_name"><?= HTML::entities($feedback->lastname); ?></span>
                                                <span class="last_name_ini"><?= HTML::entities(substr($feedback->lastname, 0, 1)); ?>.</span>
                                            </div>
                                            <div class="author-company break-word">
                                                <span class="job" style="display: <?= ( trim($position) == '' ? 'none' : '' );?>;">
                                                    <?= HTML::entities($position); ?><span class="company_comma">, </span>
                                                </span>
                                                <span class="company" style="display: <?= ( trim($company_name) == '' ? 'none' : '' );?>;">
                                                    <?= HTML::entities($company_name); ?>
                                                </span>
                                            </div>
                                            <div class="author-location-info break-word clear">
                                                <div class="author-location">
                                                    <span class="city" style="display: <?= ( trim($city) == '' ? 'none' : '' );?>;">
                                                        <?= HTML::entities($city); ?><span class="location_comma">, </span>
                                                    </span>
                                                    <span class="country" style="display: <?= ( trim($country_name) == '' ? 'none' : '' );?>;">
                                                        <?= HTML::entities($country_name); ?>
                                                    </span>
                                                </div>
                                                <div class="flag flag-<?=strtolower($feedback->countrycode)?>"></div>
                                            </div>
                                            <div class="custom-meta-data break-word clear">
                                                <?php if( ! is_null($metadata) ): ?>
                                                    <?php foreach( $metadata as $group ): ?>
                                                        <?php foreach( $group as $item ): ?>
                                                            <div class="meta-data">
                                                                <span class="meta-name"><?= HTML::entities( ucwords(str_replace('_', ' ', $item[0]->name)) ); ?> : </span>
                                                                <span class="meta-value"><?= HTML::entities($item[0]->value); ?></span>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="reviews clear">
                                        <div class="ratings clear">
                                            <div class="feedback-timestamp"><?=$feedback->daysago?></div>
                                            <div class="stars blue clear"><div class="star_rating" rating="<?=$feedback->int_rating;?>"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of feedback header -->
                                
                                <!-- feedback text bubble -->
                                <div class="feedback-text-bubble">
                                    <div class="feedback-tail"></div>
                                    <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>;">
                                        <span class="vote_count"><?= $vote_count; ?></span> people found this useful
                                    </div>
                                    <div class="feedback-text break-word">
                                        <h1 class="<?=($feedback->isfeatured == 1) ? "reg-featured" : "reg"?>"><?=$feedback->title?></h1>
                                        <p><?= nl2br(HTML::entities($feedback->text)); ?></p>
                                    </div>
                                    <!-- are there any additional info uploaded?? -->
                                    
                                    <?php if($attachments): ?>
                                        <div class="additional-contents"> 
                                            <?php if(isset($attachments->uploaded_images)): ?>
                                                <div class="uploaded-images clear">
                                                    <?php foreach($attachments->uploaded_images as $uploaded_image): ?>
                                                    <div class="uploaded-image">
                                                        <div class="padded-5">
                                                            <div class="the-thumb">
                                                                <a class="fancybox" href="<?=Config::get('application.attachments_large').'/'.$uploaded_image->name?>" rel="gallery">
                                                                    <div class="att_container"><img src="<?=Config::get('application.attachments_medium').'/'.$uploaded_image->name?>" width="100%" /></div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; //endif uploaded images ?>
                                            
                                            <?php if(isset($attachments->attached_link)): ?>                       
                                                <?
                                                $attached_url = Helpers::secure_link($attachments->attached_link->url);
                                                $attached_image = Helpers::secure_link($attachments->attached_link->image);
                                                ?>
                                                <div class="uploaded-link">
                                                    <div class="padded-5">
                                                            <div class="form-video-meta">
                                                                <?php if($attachments->attached_link->video=='yes'): ?>
                                                                    <div class="video-thumb">
                                                                        <a class="fancybox-video" href="<?=$attached_url?>" rel="gallery">
                                                                        <div class="video-circle"></div>
                                                                        <div class="the-thumb">
                                                                            <img src="<?=$attached_image?>" width="100%" />
                                                                        </div>
                                                                        </a>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="video-thumb">
                                                                        <a href="<?=$attached_url?>" target="_blank">
                                                                            <img src="<?=$attached_image?>" width="100%">
                                                                        </a>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <div class="video-details">
                                                                    <h3><?=$attachments->attached_link->title?></h3>
                                                                    <p><?=$attachments->attached_link->description?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            <?php endif; //endif attached link ?>
                                            <br/>
                                            <br/>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(isset($user) && !empty($user)): ?>
                                        <div class="admin-comment-block">
                                            <div class="admin-comment" <?=(!$feedback->admin_reply) ? 'style="display:none"' : null?>>
                                                <div class="admin-name break-word">
                                                    <!-- <?=$admin_companyname?> says.. -->
                                                    <a href="#" feedid="<?=$feedback->id?>" class="admin-delete-reply" style="float:right">[x]</a>
                                                </div>
                                                <div class="admin-message clear">
                                                    <div class="admin-avatar"><img src="<?= '/uploaded_images/company_logos/comment/' . $feedback->company_logo; ?>" width="32" height="32" /></div>
                                                    <div class="message break-word"><?= Helpers::fb_comment_str($feedback->admin_reply); ?></div>
                                                </div>
                                            </div>
                                            
                                            <? // admin comment box. ?>
                                            <div class="admin-comment-box" feedid="<?=$feedback->id?>" <?=($feedback->admin_reply) ? 'style="display:none"' : null?>>
                                                <input type="hidden" class="admin-comment-id" value="<?=$feedback->id?>">
                                                <input type="hidden" class="admin-user-id" value="<?=$user->userid?>">
                                                <div class="admin-comment-textbox-container">
                                                    <div class="admin-avatar">
                                                        <img src="<?= '/uploaded_images/company_logos/comment/' . $feedback->company_logo; ?>" width="32" height="32" />
                                                    </div>
                                                    <textarea class="admin-comment-textbox" placeholder="Leave a comment as <?=$admin_companyname;?>..."></textarea>
                                                </div>
                                                <div class="admin-comment-leave-a-reply" STYLE="DISPLAY: NONE;">
                                                    <span class="admin-logged-session">Logged in as <a href="#"><?=$user->fullname?></a></span>
                                                    <input type="button" class="adminReply regular-button" value="Post Comment" />
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <? // posted admin comment. ?>
                                        <? if($feedback->admin_reply && $feedback->admin_username): ?>
                                            <div class="admin-comment-block">
                                                <div class="admin-comment">
                                                    <div class="admin-name break-word"><!-- <?=$admin_companyname?> says.. --></div>
                                                    <div class="admin-message clear">
                                                        <div class="admin-avatar"><img src="<?= '/uploaded_images/company_logos/comment/' . $feedback->company_logo; ?>" width="32" height="32" /></div>
                                                        <div class="message break-word"><?= Helpers::fb_comment_str($feedback->admin_reply); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <? endif; ?>
                                    <? endif; ?>
                                </div><!-- end of feedback text bubble -->
                                
                                <!-- feedback user actions -->
                                <div class="feedback-options clear">
                                    <div class="feedback-icon-list clear">
                                        <div class="feedback-recommendation">
                                            <?php if( $is_recommended ): ?>
                                                <div class="green-thumb">Recommended by <?= HTML::entities($feedback->firstname); ?> to friends</div>
                                            <?php endif; ?>
                                            <div class="vote-block" <?=(!$is_recommended) ? 'style="padding-top:5px"' : null?>>
                                                <span class="vote-action <?= ($voted != 1 ? '' : 'hidden'); ?>">
                                                    Was this useful? <a href="javascript:;" class="small-btn-pin">Yes</a>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- <?php if( $is_recommended ): ?>
                                            <div class="feedback-icon">
                                                <div class="feedback-icon-class recommend-icon active-icon"></div>
                                                <div class="icon-tooltip">
                                                 <div class="icon-tooltip-text">Recommended by <?= HTML::entities($feed->feed_data->firstname); ?> to friends</div>
                                                    <div class="icon-tooltip-tail"></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="feedback-icon">
                                            <div class="feedback-icon-class useful-icon vote-action <?= ($voted ? 'active-icon off' : ''); ?>"></div>
                                            <div class="icon-tooltip">
                                                <div class="icon-tooltip-text">
                                                    <?php if( $voted ): ?>
                                                        You found this useful
                                                    <?php else: ?>
                                                        Was this useful?
                                                    <?php endif; ?>
                                                </div>
                                                <div class="icon-tooltip-tail"></div>
                                            </div>
                                        </div> -->
                                        <div style="float: right;">
                                            <div class="flag-feedback feedback-icon <?=($flagged!=1) ? 'flag-feedback-fancy' : '' ?>" fid="<?=$feedback_id;?>">
                                                <div id="flag-feedback-icon-<?=$feedback_id;?>" class="feedback-icon-class flag-icon <?= ($flagged ? 'undo_flag_inapp active-icon' : 'flag-as-inapp'); ?>"></div>
                                                <div class="icon-tooltip">
                                                    <div class="icon-tooltip-text">
                                                        <?php if( $flagged ): ?>
                                                            Undo flag
                                                        <?php else: ?>
                                                            Flag as Inappropriate
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="icon-tooltip-tail"></div>
                                                </div>
                                            </div>
                                            <div class="feedback-icon share-feedback">
                                                <div class="feedback-icon-class share-icon"></div>
                                                <div class="icon-tooltip">
                                                 <div class="icon-tooltip-text">Share</div>
                                                    <div class="icon-tooltip-tail"></div>
                                                </div>
                                                <div class="share-box">
                                                    <div class="share-box-arrow"></div>
                                                    <div class="btn-block">
                                                        <div class="fb_like_dummy" 
                                                            data-href="<?=URL::to('single/'.$feedback->id)?>"
                                                            data-layout="button_count"
                                                            data-send="false" 
                                                            data-width="80" 
                                                            data-show-faces="false"></div>
                                                    </div>
                                                    <div class="btn-block">
                                                        <a href="<?=URL::to('single/'.$feedback->id)?>"
                                                            data-url="<?=URL::to('single/'.$feedback->id)?>"
                                                            data-text="<?=$feedback->text?>"
                                                            class="tw_share_dummy">Tweet</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of feedback user actions -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of magic -->
            </div>
            <div id="magicalSpacer"></div>
            <p align="center">
                <a href="http://beta.36stories.com/"><img src="/img/fdback-logo-gray.png" /></a>
                <div class="copyright_text">Copyright - 36Stories Inc 2011-2013</div><br/>
            </p>
        </div>
    </div>
</div>

<?php
/*
|--------------------------------------------------------------------------
| Start adding JS and CSS Initialization and Override
|--------------------------------------------------------------------------
*/
?>
<?= HTML::style('/fullpage/layout/'.strtolower($panel->theme_name).'/css/S36FullpageLayout'.ucfirst($panel->theme_name).'.css'); ?>
<?= HTML::script('/fullpage/layout/'.strtolower($panel->theme_name).'/js/S36FullpageLayout'.ucfirst($panel->theme_name).'.js'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        var fullpageCommon = new S36FullpageCommon;
        var fullpageLayout = fullpageCommon.create_layout('<?php echo $panel->theme_name; ?>'); 
        fullpageLayout.init_fullpage_layout(fullpageCommon); // initialize document ready of the current layout javascripts
        fullpageCommon.init_fullpage_common(); // initialize document ready of the common javascript
        
        // S36FeedbackActions.vote();
        // S36FeedbackActions.share();
        // S36FeedbackActions.feedback_report_fancy();
        // //S36FeedbackActions.open_submission_form();
        
        S36FeedbackActions.initialize_actions(fullpageLayout, fullpageCommon);
        
        
        $(".fancybox").fancybox({
          openEffect : 'none',
          closeEffect : 'none'
         });

        $(".fancybox-video").click(function() {
        $.fancybox({
            'padding'       : 0,
            'autoScale'     : false,
            'transitionIn'  : 'none',
            'transitionOut' : 'none',
            'title'         : this.title,
            'width'         : 640,
            'height'        : 385,
            'href'          : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
            'type'          : 'swf',
            'swf'           : {
            'wmode'             : 'transparent',
            'allowfullscreen'   : 'true'
            }
        });
        return false;
        });
        
        $('.star_rating').raty({
            hints: ['BAD', 'POOR', 'AVERAGE', 'GOOD', 'EXCELLENT'],
            score: function(){
                return $(this).attr('rating');
            },
            path: '/img/',
            starOn: 'star-fill.png',
            starOff: 'star-empty.png',
            readOnly: true
        });
        
        $('.feedback-icon').hover(function(){
            $(this).find('.icon-tooltip').fadeIn('fast');
        },function(){
            $(this).find('.icon-tooltip').fadeOut('fast');
        });
        

        
    });
    /* adjust height when the whole html is loaded */
    $(window).load(function(){
        adjust_height_space()
    });
    /* adjust height when the whole html resized */
    $(window).resize(function(){
        adjust_height_space()
    });
    function adjust_height_space(){
        var browser_ht = $(window).height();
        var html_ht = $('#mainContainer').height();
        var spacer = $('#magicalSpacer');
        if(html_ht < browser_ht){
            spacer.height(browser_ht - html_ht);
        }
    }
</script>
<div id="fullpage_css"><?php echo $fullpage_css; ?></div>

<div id="flagBoxDiv" style="display:none">
<div id="flagBox">
<input class="flag-feedback-id" type="hidden" value=""/>
<div class="flagbox-content">
        <div class="flagbox-head">
            <h2>Flag as Inappropriate</h2>
        </div>
        <div class="alert-message" style="display:none">
        </div>
        <div id="report_type_list" class="flagbox-body">
            <div class="padded-5">
                <ul>
                <?php
                foreach($reportTypes as $report_id=>$report_desc):
                ?>
                    <li>
                        <input class="feedbackReportItem flag-item-<?=$report_id?>" type="radio" name="flag-item" value="<?=$report_id?>" />
                        <label id="flag-item-<?=$report_id?>" class="reportTypeLabel"><?=$report_desc?></label>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="flagbox-foot">
                <div class="fdback-buttons">
                    <ul>
                        <li><a class="continue_report" href="javascript:;">Continue</a></li>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="javascript:;">Cancel</a></li>
                    </ul>                   
                </div>
            </div>
        </div>
        
        <div id="report_user_info" class="flagbox-body" style="display:none">
            <div class="padded-5">
                <ul>
                    <li>To Continue, Fill up the fields below <br /><br /></li>
                        <li>
                            <label>Your Name :</label><br />
                            <input id="report_name" type="text" name="flagger-name" class="regular-text" title="Your Name" />
                        </li>
                        <li>
                            <label>Your Email :</label><br />
                            <input id="report_email" type="text" name="flagger-email" class="regular-text" title="Your Email" />
                        </li>
                        <li>
                            <label>Your Company (optional) :</label><br />
                            <input id="report_company" type="text" name="flagger-company" class="regular-text" title="Your Company (optional)" />
                        </li>
                        <li>
                            <label>Comments (optional) :</label><br />
                            <textarea id="report_comment" title="Comments"></textarea>
                        </li>
                    </ul>
                </div>
            <div class="flagbox-foot">
            <div class="fdback-buttons">
                    <ul>
                        <li><a id="back_report" href="javascript:;">Back</a></li>
                        <li><a class="continue_report" href="javascript:;">Continue</a></li>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="javascript:;">Cancel</a></li>
                    </ul>                   
            </div>
            </div>
        </div>

        <div id="report_final" class="flagbox-body" style="display:none">
            <div class="flagbox-foot">
            <div class="fdback-buttons">
                    <ul>
                        <li><a onClick="parent.jQuery.fancybox.close();" href="javascript:;">Close</a></li>
                    </ul>                   
            </div>
            </div>
        </div>

    </div>
</div>
</div>
</body>
</html>
