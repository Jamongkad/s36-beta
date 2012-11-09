<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
    $admin = (!empty($user))? 1 : 0;
?>
<script type="text/javascript">
$(document).ready(function(){
    <?php if(isset($hosted->background_image) && !empty($hosted->background_image)) { ?>
        $('body').css('background-image','url(uploaded_images/hosted_background/<?=$hosted->background_image?>)')
    <?php } ?>
});

</script>

<div id="bodyWrapper">
    <div id="bodyContent">
        <!-- new header October 4 2012 -->
        <div id="pageCover">
            <?php if($admin == 1): ?>
            <div id="changeCoverButton">
                <div id="changeButtonText">            
                    Change Cover
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" id="logoUpload" name="clientLogoImg" style="width:88px;height:18px;position:fixed;z-index:1000;cursor:pointer;opacity:0;" onchange="upload_new_logo()" />
                </form>
            </div>
            
            <div id="saveCoverButton">
                Save Cover
            </div>
            <div id="dragPhoto">
                Drag Image to Reposition Cover
            </div>
            <?php endif; ?>
            
            <div id="theCover" class="draggable">
                <img src="<?=$company->coverphoto_src?>" id="coverPhoto" style="top:<?=$company->coverphoto_top?>px;" />
            </div>
            <div class="social-buttons">
                <ul>
                    <li><a href="<?=$company->fb_link?>"><img src="img/facebook.png" title="Visit us on Facebook!" /></a></li>
                    <li><a href="<?=$company->twit_link?>"><img src="img/twitter.png" title="Follow us on Twitter!" /></a></li>
                </ul>
            </div>

           
        </div>
        <div id="pageDesc">
            <div class="grids">
                <div class="g3of4">
                    <div class="the-description">
                        <?=$company->description?>
                    </div>
                </div>
                <div class="g1of4">
                    <div class="send-feedback">
                        <input type="button" class="funky-button" value="Send in Feedback" />
                    </div>
                </div>
            </div>
        </div>
        <!-- end of new header October 4 2012 -->
        <div id="pageTitle">
            <div class="grids">
                <div class="g4of5">
                        <h1>Hear what our customers have to say</h1>
                </div>
            </div>
            <div class="meta">
                <?=$feed_count->published_feed_count?> testimonials in total 
                <?if($feed_count->todays_count > 0):?>
                    - <?=$feed_count->todays_count?> were just sent in today.
                <?endif?>
            </div>
        </div>


        <!--
        <div id="companyDetails" class="block">
            <div class="companyLogo">
                <img src="img/company-logo-filler.jpg" />
            </div>
            <div class="companyDetails">
                <h2>Company Profile</h2>
                <p>Acme in specializes in creating widgets for everyday use. Thousands of 
customers worldwideuse Acme products and get better each and everyday. 
Visit Acme's website today for more information. </p>
                <br />
                <div class="companyLinks">
                    <ul>
                        <li><a href="#" class="website">Visit Our Website</a></li>
                        <li><a href="#" class="facebook">Join us on Facebook</a></li>
                        <li><a href="#" class="twitter">Follow us on Twitter</a></li>
                    </ul>
                </div>
            </div>
          
        </div>
        --> 
        <div class="feedback-header">
            <h2 class="twitter">Recently on Twitter (via @<?=basename($company->twit_link)?>) </h2>
            <span>
            <a href="https://twitter.com/<?=basename($company->twit_link)?>" class="twitter-follow-button" data-show-count="false">Follow @<?=basename($company->twit_link)?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</span>
        </div>
        <div id="twitterFeedbacks">

            <?php foreach($tweets as $tweet): ?>
            <div class="feedback twt-feedback">
                <div class="feedbackContents">
                    <div class="feedbackBlock">
                        <div class="feedbackAuthor">
                            <div class="feedbackAuthorAvatar"><img src="<?=$tweet->profile_image_url?>" width="48" height="48" /></div>
                            <div class="feedbackAuthorDetails">
                                <h2><?=$tweet->from_user_name?> <a href="#">@<?=$tweet->from_user?></a></h2>
                            </div>
                        </div>
                        <div class="feedbackText">
                            <div class="feedbackTextTail"></div>
                            <div class="feedbackTextBubble"><p><?=$tweet->text?></p></div>
                        </div>
                        <div class="feedbackDate"><?=$tweet->created_at?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="load-more-block align-center">
            <a href="#" class="load-more-tweets">Load More Tweets</a>
        </div> 
        
        <div class="feedback-header">
            <h2 class="s36">Recently Posted Feedback</h2>
        </div> 
        <div id="theFeedbacks">
            
<?=$feeds?>
        </div>
        <div class="block" style="text-align:center;font-size:11px;color:#333;padding-bottom:10px;">Powered by 36Stories</div>
    </div>
</div>