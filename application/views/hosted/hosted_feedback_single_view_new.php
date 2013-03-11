<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta property="og:title" content="<?=strip_tags($feedback->title)?>"/> 
    <meta property="og:description" content="<?=strip_tags($feedback->text)?>"/> 
    <meta property="og:type" content="article"/> 
    <?if($feedback->avatar):?>
        <meta property="og:image" content='<?=URL::to(Config::get('application.avatar150_dir').'/'.$feedback->avatar)?>'/> 
    <?else:?>
        <meta property="og:image" content='<?=URL::to('img/36logo2.png')?>'/> 
    <?endif?>
    <meta property="og:url" content="<?=URL::to('single/'.$feedback->id)?>"/> 
    <meta property="og:site_name" content="36Stories: Feedback made easy."/> 
    <meta property="fb:app_id" content="<?=$fb_id?>"/>
    <?php
    /*
    |--------------------------------------------------------------------------
    | Third-Party
    |--------------------------------------------------------------------------
    */
    echo HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
    echo HTML::script('https://platform.twitter.com/widgets.js');
    echo HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.0.4/angular.min.js');
    echo HTML::script('https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js');
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
    /*
    |--------------------------------------------------------------------------
    | Single Page
    |--------------------------------------------------------------------------
    */
    echo HTML::style('/fullpage/common/css/S36SinglePage.css'); 
    echo HTML::style('/fullpage/common/css/S36SingleCommon.css'); 
    echo HTML::style('/fullpage/common/css/override.css');  // moved here from application/views/partials/fullpage_header.php.
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
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
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
    });
    </script>
</head>
<body>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<div id="fb-root"></div>
<script type="text/javascript">
    window.fbAsyncInit = function() {
            // init the FB JS SDK
        FB.init({
            appId      : '<?=$fb_id;?>', // App ID from the App Dashboard
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
<div id="bodyColorOverlay"></div>
<div id="mainWrapper">
	<div id="fadedContainer">
    	<div id="mainContainer">

            <div id="coverPhotoContainer">
                <div id="coverPhoto">
                    <?php if( ! is_null($company->coverphoto_src) ): ?>
                        <img width="850px" dir="/uploaded_images/coverphoto/" basename="" 
                             src="/uploaded_images/coverphoto/<?php echo $company->coverphoto_src; ?>" 
                             style="top: <?php echo $company->coverphoto_top; ?>px; position: relative;" />
                    <?php else: ?>
                        <?php if( ! is_null($user) ): ?>
                            <img dir="/uploaded_images/coverphoto/" basename="" src="img/sample-cover.jpg" />
                        <?php else: ?>
                            <img width="850px" src="img/public-coverphoto.jpg" />
                        <?php endif; ?>
                    <?php endif; ?>
                </div>                
                <div id="socialLinkIcons" class="clear">
                    <?php if(!empty($panel->facebook_url)): ?>
                        <div class="social-icon fb"><a id="fb_url" href="<?= $panel->facebook_url; ?>">
                            <img src="/fullpage/common/img/facebook.png" title="Facebook Page" />
                        </a>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($panel->twitter_url)): ?>
                        <div class="social-icon tw"><a href="<?= $panel->twitter_url; ?>">
                            <img src="/fullpage/common/img/twitter.png" title="Twitter Page" />
                        </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <div itemscope itemtype="https://data-vocabulary.org/Review-aggregate">
            <meta itemprop="itemreviewed" content="<?php echo $company->company_name; ?>" />
            <!--
            <div class="hosted-block">
                <div class="company-description clear">
                    <div class="company-text">
                        <? // keep the content of fullpage_desc_text in one line. ?>
                        <div id="fullpage_desc" class="<?= (! is_null($user) ? 'editable' : ''); ?>" itemprop="summary"><?= nl2br( HTML::entities($company->description) ); ?></div>
                        <?php if( ! is_null($user) ): ?>
                            <textarea id="fullpage_desc_textbox" rows="3"></textarea>
                        <?php endif; ?>
                    </div>
                    <div class="send-button" widgetkey="<?=$company->widgetkey?>">
                        <a href="javascript:;">
                            Send in feedback
                        </a>
                    </div>
                </div>
            </div>
            -->
            <br/><br/> 
            <div class="hosted-block">
                <div class="company-reviews clear">
                    <div class="company-recommendation">
                        <div class="green-thumb"> 
                            <?php echo round(($company->total_recommendations / $company->total_feedback) * 100); ?>% 
                            of our customers recommend us to their friends.
                        </div>
                    </div>
                    <div class="company-rating"> 
                        <div class="review-count">Based on <span itemprop="count"><?php echo $company->total_feedback; ?></span> reviews</div>
                        <div class="stars blue clear"><div class="star_rating" rating="<?php echo round($company->avg_rating); ?>"></div></div>
                        <meta itemprop="rating" content="<?php echo round($company->avg_rating); ?>" /><!-- for rich snippets. -->
                    </div>
                </div>
            </div>
            <!-- lightbox notification -->
            <div id="lightboxNotification">
                <div class="lightbox-pandora">
                    <div class="lightbox-header">Oops! Something went wrong..</div>
                    <div class="lightbox-body">
                        <div class="lightbox-message error">
                            <ul>
                                <li>Error Message</li><li>Error Message</li>
                            </ul>
                        </div>
                        <div class="lightbox-buttons">
                            <a href="#" class="lightbox-button" onclick="javascript:close_lightbox();">CLOSE</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of lightbox notification -->
            <!-- lightbox container -->
            <div class="lightbox-s"></div>
            <div class="lightbox">
                <div class="uploaded-images-close"></div>
                <div class="uploaded-images-popup">
                    <div class="uploaded-images-container">
                        <div class="uploaded-images-view"> 
                            <div class="uploaded-images-content">
                           
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of lightbox container -->
            <?php
            $feedback_id                = $feedback->id;
            $tw_marker                  = ($feedback->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
            $avatar                     = Config::get('application.avatar48_dir').'/'.$feedback->avatar;
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
            ?>
            <div id="feedbackContainer">
            	<!-- this is where the magic begins -->
                <div id="threeColumnLayout"> 
                    <div class="feedback-list">
                        <div class="feedback regular-featured">
                            <?=$tw_marker?>
                            <div class="regular-featured-contents">
                                <!-- feedback header -->
                                <div class="feedback-header clear">
                                    <div class="author">
                                        <div class="author-avatar"><img src="<?=$avatar?>" width="48" height="48" /></div>	
                                        <div class="author-information">
                                            <div class="author-name clear">                                            
                                                <span class="first_name"><?= HTML::entities($feedback->firstname); ?></span>
                                                <span class="last_name"><?= HTML::entities($feedback->lastname); ?></span>
                                                <span class="last_name_ini"><?= HTML::entities(substr($feedback->lastname, 0, 1)); ?>.</span>
                                            </div>
                                            <div class="author-company">
                                                <span class="job" style="display: <?= ( trim($position) == '' ? 'none' : '' );?>;">
                                                    <?= HTML::entities($position); ?><span class="company_comma">, </span>
                                                </span>
                                                <span class="company" style="display: <?= ( trim($company_name) == '' ? 'none' : '' );?>;">
                                                    <?= HTML::entities($company_name); ?>
                                                </span>
                                            </div>
                                            <div class="author-location-info clear">
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
                                            <div class="custom-meta-data clear">
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
                                            <div class="star_rating" rating="<?=$feedback->int_rating;?>"></div>
                                            <div class="feedback-timestamp"><?=$feedback->daysago?></div>
                                        </div>
                                        <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>;">
                                            <span class="vote_count"><?= $vote_count; ?></span> people found this useful
                                        </div>
                                    </div>
                                </div>
                                <!-- end of feedback header -->
                                
                                <!-- feedback text bubble -->
                                <div class="feedback-text-bubble">
                                    <div class="feedback-tail"></div>
                                    <div class="feedback-text">
                                        <p><?= HTML::entities($feedback->text);?></p>
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
                                                                    <img src="<?=Config::get('application.attachments_medium').'/'.$uploaded_image->name?>" width="100%" />
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
                                    
                                </div>
                                <!-- end of feedback text bubble -->
                                <!-- feedback user actions -->
                                <!--
                                <div class="feedback-options clear">
                                    <div class="feedback-recommendation">
                                        <?php if( $is_recommended ): ?>
                                            <div class="green-thumb">Recommended by <?= HTML::entities($feedback->firstname); ?> to friends</div>
                                        <?php endif; ?>
                                        <div class="vote-block">
                                            <span class="vote-action <?= ($voted != 1 ? '' : 'hidden'); ?>">
                                                Was this useful? <a href="#" class="small-btn-pin">Yes</a>
                                            </span>
                                            <span class="undo_vote <?= ($voted == 1 ? '' : 'hidden'); ?>">
                                                Undo vote
                                            </span>
                                        </div>
                                    </div>
                                    <div class="feedback-actions clear">
                                        <span class="flag-as <?= ($flagged != 1 ? '' : 'hidden'); ?>">
                                            Flag as inappropriate
                                        </span>
                                        <span class="undo_flag <?= ($flagged == 1 ? '' : 'hidden'); ?>">
                                            Undo flag
                                        </span>
                                        <span class="share-button">
                                            Share
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
                                        </span>
                                    </div>
                                </div>
                                -->
                                <!-- end of feedback user actions -->
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                <!-- end of magic -->
            </div>
            <p align="center"><img src="/img/36stories-logo.png" /></p>
        </div>
    </div>
</div>
</body>
</html>
