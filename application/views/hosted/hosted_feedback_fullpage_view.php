<?php
$admin = (!empty($user))? 1 : 0;
/*pull theme information for customed css and js*/
echo (isset($hosted->theme_css)) ? '<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/'.$hosted->theme_css.'" />' : null;
echo (isset($hosted->theme_js)) ? '<script type="text/javascript" src="themes/hosted/fullpage/'.$hosted->theme_js.'"></script>' : null;
?>

<script type="text/javascript">

$(document).ready(function(){
    <?php 
    /* Change fullpage background if set from admin */
    if(isset($hosted->background_image) && !empty($hosted->background_image)):?>
        $('body').css('background-image','url(uploaded_images/hosted_background/<?=$hosted->background_image?>)')
    <?php endif ?>
});

</script>

<div id="bodyWrapper">

    <div id="bodyContent">
        <div id="pageCover" <?=(!$admin and !$company->coverphoto_src) ? "style='height: 40px;'" : null?>>

            <?php if($admin == 1): ?>
                <div id="changeCoverButton">
                    <div id="changeButtonText">            
                        Change Cover
                    </div>
                    <input id="logoUpload" 
                           type="file" 
                           name="clientLogoImg" 
                           data-url="imageprocessing/upload_coverphoto" 
                           style="width:88px;height:18px;position:fixed;z-index:1000;cursor:pointer;opacity:0;" multiple my-fileupload />
                </div>

                <div id="saveCoverButton" save-myupload>
                    Save Cover
                </div>

                <div id="dragPhoto">
                    Drag Image to Reposition Cover
                </div>
            <?php endif; ?>
 
            <div id="theCover" class="draggable">
                <?if($company->coverphoto_src):?>
                     <img src="<?=$company->coverphoto_src?>" id="coverPhoto" style="top:<?=$company->coverphoto_top?>px;" />
                <?else:?>
                     <?if($admin):?>
                         <img src="" id="coverPhoto" />
                         <img src="/img/cover-photo-placeholder.jpg" id="defaultCoverPhoto" width="100%" />
                     <?endif?>
                <?endif;?>
            </div>

            <div class="social-buttons">
                <ul>
                <?
                    
                    if($twitter = $company_social->fetch_social_account('twitter')) {
                        $tw = Helpers::unwrap($twitter->socialaccountvalue);
                        echo '<li><a href="https://www.twitter.com/'.$tw['accountName'].'"><img src="img/twitter.png" title="Follow us on Twitter!" /></a></li>';
                    }

                    if($facebook = $company_social->fetch_social_account('facebook')) {
                        $fb = Helpers::unwrap($facebook->socialaccountvalue);
                        echo '<li><a href="https://www.facebook.com/'.$fb['accountName'].'"><img src="img/facebook.png" title="Visit us on Facebook!" /></a></li>';
                    }
                ?>
                 

                </ul>

            </div>
        </div>
        <!-- end of page cover -->
        <div id="pageDesc">

            <div class="grids">

                <div class="g3of4">

                    <div class="the-description">

                        <?=$company->description?>

                    </div>

                </div>

                <div class="g1of4">

                    <div class="send-feedback">

                        <a href="<?=$company->company_name?>/submit"><input type="button" class="funky-button" value="Send in Feedback" /></a>

                    </div>

                </div>

            </div>

        </div>

        

        <!-- end of new header October 4 2012 --> 
       <div id="pageTitle">
            <h1><?=$hosted->header_text?></h1>
            <div class="meta">
                <?=$feed_count->published_feed_count?> testimonials in total 
                <?if($feed_count->todays_count > 0):?>
                    - <?=$feed_count->todays_count?> were just sent in today.
                <?endif?>
            </div>
        </div>
        <!-- feedbacks are seperated by date which are held inside feedback-date-block container -->
        <?=View::make('hosted/partials/hosted_feedback_partial_view', Array('collection' => $feeds))?>
        <div id="feedback-landing"></div>
        <div class="block" style="background:#ececec;text-align:center;font-size:11px;color:#a8a8a8;padding:10px 0px;">Powered by 36Stories</div>
