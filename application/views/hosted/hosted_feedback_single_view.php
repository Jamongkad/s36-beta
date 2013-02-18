<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <?php
        /*
        |--------------------------------------------------------------------------
        | Third-Party
        |--------------------------------------------------------------------------
        */
        ?>
        <?= HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'); ?>
        <?= HTML::script('https://platform.twitter.com/widgets.js" type="text/javascript'); ?>

        <?php
        /*
        |--------------------------------------------------------------------------
        | Global
        |--------------------------------------------------------------------------
        */
        echo HTML::script('/min/?g=Global');
        
        /*
        |--------------------------------------------------------------------------
        | Fullpage Common
        |--------------------------------------------------------------------------
        */
        echo HTML::script('/min/?g=FullpageCommon');
        
        /*
        |--------------------------------------------------------------------------
        | Facebook Open Graph
        |--------------------------------------------------------------------------
        */
        ?>
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

    </head>
<body>
<div id="fb-root"></div>
<script>
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
<?php
//echo "<pre>";print_r($feedback);echo "</pre>";
$feedback_id                = $feedback->id;
$tw_marker                  = ($feedback->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
$avatar                     = Config::get('application.avatar48_dir').'/'.$feedback->avatar;
$attachments                = (!empty($feedback->attachments)) ? json_decode($feedback->attachments) : false;
$vote_count                 = $feedback->vote_count;
$voted                      = $feedback->useful;
$flagged                    = $feedback->flagged_as_inappr;
$metadata                   = $feedback->metadata;

?>
<div id="bodyColorOverlay"></div>
<div id="mainWrapper">
    <div id="fadedContainer">
        <div id="mainContainer">
            <div id="coverPhotoContainer">
                <div id="coverPhoto">
                    <img width="850px" dir="/uploaded_images/coverphoto/" basename="" src="/uploaded_images/coverphoto/<?php echo $company->coverphoto_src; ?>" style="top: <?php echo $company->coverphoto_top; ?>px; position: relative;" />
                </div>
                <div id="socialLinkIcons" class="clear">
                    <div class="social-icon fb"><a id="fb_url" href="<?= $panel->facebook_url; ?>">
                        <img src="/fullpage/common/img/facebook.png" title="Facebook Page" />
                    </a></div>
                    <div class="social-icon tw"><a href="<?= $panel->twitter_url; ?>">
                        <img src="/fullpage/common/img/twitter.png" title="Twitter Page" />
                    </a></div>
                </div>
            </div>
            <div class="hosted-block">
                <div class="company-description clear">
                    <div class="company-text">
                        <?=$company->description?>                       
                    </div>
                    <div class="send-button" widgetkey="<?=$company->widgetkey?>">
                        <a href="javascript:;">
                            Send in feedback
                        </a>
                    </div>
                </div>
            </div>
            
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
        <div id="feedbackContainer">
        <div id="threeColumnLayout"> 
            <div class="feedback-list">
            <div class="feedback regular-featured">
                <div class="twitter-marker"></div>
                <div class="regular-featured-contents">
                    <!-- feedback header -->
                    <div class="feedback-header clear">
                        <div class="author">
                            <div class="author-avatar"><img src="<?=Config::get('application.avatar48_dir').'/'.$feedback->avatar?>" width="48" height="48" /></div>  
                            <div class="author-information">
                                <div class="author-name clear">
                                    <span class="first_name"><?= HTML::entities($feedback->firstname); ?></span>
                                    <span class="last_name"><?= HTML::entities($feedback->lastname); ?></span>
                                </div>
                                <div class="author-company">
                                    <span class="job"><?= HTML::entities($feedback->position); ?><span class="company_comma">, </span></span>
                                    <span class="company"><?= HTML::entities($feedback->companyname); ?></span>
                                </div>
                                <div class="author-location-info clear">
                                    <div class="author-location">
                                        <span class="city"><?= HTML::entities($feedback->city); ?><span class="location_comma">, </span></span>
                                        <span class="country"><?= HTML::entities($feedback->countryname); ?></span>
                                    </div>
                                    <div class="flag flag-<?=strtolower($feedback->countrycode)?>"></div>
                                </div>
                            </div>  
                        </div>

                        <div class="reviews clear">
                            <div class="ratings clear">
                                <div class="feedback-timestamp"><?=$feedback->daysago?></div>
                                <div class="stars blue clear">
                                    <div class="star_rating" rating="<?=$feedback->int_rating;?>"></div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of feedback header -->
                    
                    <!-- feedback text bubble -->
                    <div class="feedback-text-bubble">
                        <div class="feedback-tail"></div>
                        <div class="rating-stat" style="display: <?= ($vote_count == 0 ? 'none' : ''); ?>">
                            <span class="vote_count"><?php echo $vote_count; ?></span> people found this useful
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
                        <div class="feedback-text">
                            <?=$feedback->text?>
                        </div>
                        <!-- are there any additional info uploaded?? -->
                        <?php if($attachments): ?>
                        <div class="additional-contents">
                            <!-- is it an image? -->
                            <?php if(isset($attachments->uploaded_images)): ?>
                                <div class="uploaded-images clear">
                                    <?php foreach($attachments->uploaded_images as $uploaded_image): ?>
                                    <div class="uploaded-image">
                                        <div class="padded-5">
                                            <div class="the-thumb">
                                                <input type="hidden" class="large-image-url" value="<?=$uploaded_image->large_url?>"/>
                                                <img src="<?=$uploaded_image->small_url?>" width="100%" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; //endif uploaded images ?>

                            <?php if(isset($attachments->attached_link)): ?>                       
                                <div class="uploaded-link">
                                    <div class="padded-5">
                                            <div class="form-video-meta">
                                                <?php if($attachments->attached_link->video=='yes'): ?>
                                                    <div class="video-thumb">
                                                        <div class="video-circle"></div>
                                                        <div class="the-thumb">
                                                            <input type="hidden" class="link-url" value="<?=$attachments->attached_link->url?>"/>
                                                            <img src="<?=$attachments->attached_link->image?>" width="100%">
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="video-thumb">
                                                        <a href="<?=$attachments->attached_link->url?>" target="_blank">
                                                            <img src="<?=$attachments->attached_link->image?>" width="100%">
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
                            </div>
                        <?php endif; ?>
                        <br />
                    </div>
                    <!-- end of feedback text bubble -->
                    <!-- feedback user actions -->
                    <div class="feedback-options clear">
                        <div class="feedback-recommendation">
                            <div class="green-thumb">Recommended by <?= HTML::entities($feedback->firstname); ?> to friends</div>
                        </div>
                        <?php if( $voted != 1 ): ?>
                        <div class="feedback-vote">
                            <span class="vote-action">Was this useful? <a href="#" class="small-btn-pin">Yes</a></span>
                        </div>
                        <?php endif; ?>

                        <div class="feedback-actions clear">
                            <?php if( $flagged != 1 ): ?>
                                <span class="flag-as">Flag as inappropriate</span>
                            <?php endif; ?>
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
                    <!-- end of feedback user actions -->
                </div>
            </div>
            </div>
        </div>
        </div>
        <p align="center"><img src="/img/36stories-logo.png" /></p>
    </div>
    </div>
</div>
<script type="text/javascript">
<?=(!empty($hosted->background_image)) ? '$("body").css("background-image","url(/uploaded_images/hosted_background/'.$hosted->background_image.')");' : '' ?>
    $(document).ready(function(){
        S36FeedbackActions.initialize_actions();
    });
</script>
<?php 
/*
/ In-line css for fullpage
*/
echo $fullpage_css;
?>
</body>
</html>