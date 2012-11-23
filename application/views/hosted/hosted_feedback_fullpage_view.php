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
                    <li><a href="https://www.facebook.com/<?=$company->facebook_username?>"><img src="img/facebook.png" title="Visit us on Facebook!" /></a></li>
                    <li><a href="https://www.twitter.com/<?=$company->twitter_username?>"><img src="img/twitter.png" title="Follow us on Twitter!" /></a></li>
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
        <?php 
        /*
        /   START FEEDBACK LOOP
        */
        foreach ($feeds as $feed_group => $feed_list) : 
        ?>
        <div class="feedback-date-block">
            <div class="feedback-date">
                <h2><?=date('M d',$feed_group)?></h2>
                <span><?=ucfirst(Helpers::relative_time($feed_group))?></span>
            </div>
            <div class="feedback-spine"></div>
            <div class="spine-spacer"></div>
            <div class="the-feedbacks">
        <?php /*start feedback info*/ 
            foreach ($feed_list as $feed) :
                $twfeedback = '';
                $class      = '';
                switch ($feed->feed_data->origin) {
                    case 's36':
                        if($feed->feed_data->isfeatured == 1){
                            $feed->feed_data->avatar = (!empty($feed->feed_data->avatar)) ? '/uploaded_cropped/150x150/'.$feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
                            $avatar = '<img src="'.$feed->feed_data->avatar.'"  class="large-avatar"/>';
                            $class  = 'featured';
                        }
                        else{
                            $feed->feed_data->avatar = (!empty($feed->feed_data->avatar)) ? '/uploaded_cropped/48x48/'.$feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
                            $avatar = '<img src="'.$feed->feed_data->avatar.'"  class="small-avatar"/>';   
                            $class  = 'normal';
                        }?>

                            <div class="feedback <?=$class?>">
                                <div class="feedback-branch"></div>
                                <div class="feedbackContents">
                                    <div class="feedbackBlock">
                                        <div class="feedbackAuthor">
                                            <div class="feedbackAuthorAvatar"><?=$avatar?></div>
                                            <div class="feedbackAuthorDetails">
                                                <h2><?=$feed->feed_data->firstname.' '.$feed->feed_data->lastname?></h2>
                                                <p><span style="float:left"><?=$feed->feed_data->countryname?></span><span class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></span></p>
                                            </div>
                                        </div>
                                        <div class="feedbackText">
                                            <div class="feedbackTextTail"></div>
                                            <div class="feedbackTextBubble">
                                                <p><?=$feed->feed_data->text?></p>
                                            </div>
                                        </div>
                                        <div class="feedbackDate"><?=date('W F Y',$feed->feed_data->unix_timestamp)?></div>
                                    </div>
                                    <div class="feedbackBlock">
                                        <div class="feedbackMeta"> 
                                            <div class="feedbackSocial">
                                                <div class="feedbackSocialTwitter"><a href="/hosted/single/<?=$feed->feed_data->id?>" class="twitter-share-button">Tweet</a></div>
                                                <div class="feedbackSocialFacebook">
                                                    <fb:like href="/hosted/single/<?=$feed->feed_data->id?>" send="false" 
                                                             layout="button_count" width="100" show_faces="false" style="float:left">
                                                    </fb:like>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        break;
                    case 'tw':
                        $twfeedback = 'twt-feedback';
                        if($feed->feed_data->isfeatured == 1){
                            $feed->feed_data->avatar = (!empty($feed->feed_data->avatar)) ? $feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
                            $avatar = '<img src="'.$feed->feed_data->avatar.'"  class="large-avatar"/>';
                            $class = 'twt-featured';
                        }else{
                            $feed->feed_data->avatar = (!empty($feed->feed_data->avatar)) ? $feed->feed_data->avatar : '/img/48x48-blank-avatar.jpg';
                            $avatar = '<img src="'.$feed->feed_data->avatar.'"  class="small-avatar"/>';
                        }?>

                            <div class="feedback twt-feedback <?php echo $class?>">
                                <div class="feedback-branch"></div>
                                <div class="twitter-marker"></div>
                                <div class="feedbackContents">
                                    <div class="feedbackBlock">
                                        <div class="feedbackAuthor">
                                            <div class="feedbackAuthorAvatar"><?=$avatar?></div>
                                        </div>
                                        <div class="feedbackText">
                                            <div class="feedbackTextTail"></div>
                                            <div class="feedbackTextBubble">
                                                <div class="feedbackAuthorDetails">
                                                    <h2><?=$feed->feed_data->firstname?> <a href="#">@<?=$feed->feed_data->firstname?></h2>
                                                </div>
                                                <div class="feedbackTextContent"><p><?=$feed->feed_data->text?></p></div>
                                                <div class="feedbackDate"><?=date('W F Y',$feed->feed_data->unix_timestamp)?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        break;
                    default:
                        break;
                }
        ?>
        
        <?php endforeach; //end feedback box?>
        <div class="spine-spacer"></div>
        </div>
        <?php endforeach; //end feedback list?>
        <div id="feedback-landing"></div>
        <div class="block" style="background:#ececec;text-align:center;font-size:11px;color:#a8a8a8;padding:10px 0px;">Powered by 36Stories</div>
