
<?php
$admin = (!empty($user))? 1 : 0;
/*
/ pull theme information for customed css
*/
?>
<link type="text/css" rel="stylesheet" href="themes/hosted/fullpage/<?=$theme->theme_css?>" />

<?php 
/*start document load*/ 
?>
<script type="text/javascript">
$(document).ready(function(){
    
    <?php 
    /* Change fullpage background if set from admin
    
    if(isset($hosted->background_image) && !empty($hosted->background_image)) { ?>
        $('body').css('background-image','url(uploaded_images/hosted_background/<?=$hosted->background_image?>)')
    <?php } */?>
    
});
</script>
<?php 
/*end document load*/ 
?>

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
        
        <!-- feedbacks are seperated by date which are held inside feedback-date-block container -->
        <div class="feedback-date-block">
            <!-- the big circle at the start of each feedback blocks. sorted by date -->
            <div class="feedback-date">
                <h2>Oct 30</h2>
                <span>Today</span>
            </div>
            <!-- end of big circle -->
            <!-- the fullpage spine -->
            <div class="feedback-spine"></div>
            <!-- end of the spine -->
            <!-- space between the circled date and the feedbacks -->
            <div class="spine-spacer"></div>
            <!-- end of space -->
            <!-- the feedbacks! -->
            <div class="the-feedbacks">
                <?php 
                    $ctr = 0;
                foreach($tweets as $tweet): ?>
                <?php 
                    $ctr++;
                if(($ctr % 7)== 0):
                    $class = 'twt-featured';
                else:
                    $class = '';
                endif;
                ?>
                
                <div class="feedback twt-feedback <?php echo $class?>">
                    <div class="feedback-branch"></div>
                    <div class="twitter-marker"></div>
                    <div class="feedbackContents">
                        <div class="feedbackBlock">
                            <div class="feedbackAuthor">
                                <div class="feedbackAuthorAvatar"><img src="<?php echo $tweet->profile_image_url?>" width="48" height="48" /></div>
                            </div>
                            <div class="feedbackText">
                                <div class="feedbackTextTail"></div>
                                <div class="feedbackTextBubble">
                                    <div class="feedbackAuthorDetails">
                                        <h2><?php echo $tweet->from_user_name?> <a href="#">@<?php echo $tweet->from_user?></a></h2>
                                    </div>
                                    <div class="feedbackTextContent"><p><?php echo $tweet->text?></p></div>
                                    <div class="feedbackDate"><?php echo $tweet->created_at?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php endforeach; ?>
            </div>
            <!-- end of feedbacks -->
            <!-- start of another spacer -->
            <div class="spine-spacer"></div>
            <!-- end of spacer -->
            
        </div>
        <?php /* 

        <div class="feedback-date-block">
            <div class="feedback-date">
                <h2>Oct 19</h2>
                <span>Yesterday</span>
            </div>
            <div class="feedback-spine"></div>
            <div class="spine-spacer"></div>
            <!-- changed the theFeedback ID to class so masonry will run correctly -->
            <div class="the-feedbacks">
                <div class="feedback featured">
                    <div class="feedback-branch"></div>
                    <div class="feedbackContents">
                        <div class="feedbackBlock">
                            <div class="feedbackAuthor">
                                <div class="feedbackAuthorAvatar"><img src="img/friendzone.png" width="150" height="150" /></div>
                                <div class="feedbackAuthorDetails">
                                    <h2>Rosary Anne Matusoc</h2>
                                    <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                    <p><span style="float:left">New York, USA</span><span class="flag flag-ph"></span></p>
                                </div>
                            </div>
                            <div class="feedbackText">
                                <div class="feedbackTextTail"></div>
                                <div class="feedbackTextBubble">
                                    <p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!"</p>
                                    <p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!"</p>
                                </div>
                            </div>
                            <div class="feedbackDate">26th April 2012</div>
                        </div>
                        <div class="feedbackBlock">
                            <div class="feedbackMeta">
                                <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div>  -->
                                <div class="feedbackSocial">
                                    <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                    <div class="feedbackSocialFacebook"><fb:like href="http://dev.gearfish.com/hosted/single/230" send="false" layout="button_count" width="100" show_faces="false" style="float:left"></fb:like></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feedback normal">
                    <div class="feedback-branch"></div>
                    <div class="feedbackContents">
                        <div class="feedbackBlock">
                            <div class="feedbackAuthor">
                                <div class="feedbackAuthorAvatar"><img src="img/enna.png" width="48" height="48" /></div>
                               
                                <div class="feedbackAuthorDetails">
                                    <h2>Enna Serrano</h2>
                                    <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                    <p><span class="twitter-username"><a href="#">@realEnna</a></span></p>
                                </div>
                            </div>
                            <div class="feedbackText">
                                <div class="feedbackTextTail"></div>
                                <div class="feedbackTextBubble"><p>I love your Company! #ForestGreen</p></div>
                            </div>
                            <div class="feedbackDate">26th April 2012</div>
                        </div>
                        <div class="feedbackBlock">
                            <div class="feedbackMeta">
                                <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> -->
                                <div class="feedbackSocial">
                                    <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                    <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feedback normal">
                    <div class="feedback-branch"></div>
                    <div class="feedbackContents">
                        <div class="feedbackBlock">
                            <div class="feedbackAuthor">
                                <div class="feedbackAuthorAvatar"><img src="img/samchloe.png" width="48" height="48" /></div>
                                <div class="feedbackAuthorDetails">
                                    <h2>Sam Chloe Ranada</h2>
                                    <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                    <p><span class="twitter-username"><a href="#">@iamsammychu</a></span></p>
                                </div>
                            </div>
                            <div class="feedbackText">
                                <div class="feedbackTextTail"></div>
                                <div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p></div>
                            </div>
                            <div class="feedbackDate">26th April 2012</div>
                        </div>
                        <div class="feedbackBlock">
                            <div class="feedbackMeta">
                                <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> -->
                                <div class="feedbackSocial">
                                    <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                    <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feedback normal">
                    <div class="feedback-branch"></div>
                    <div class="feedbackContents">
                        <div class="feedbackBlock">
                            <div class="feedbackAuthor"><!-- 
                                <div class="feedbackAuthorAvatar"><img src="imgenna.png" width="48" height="48" /></div>
                                -->
                                <div class="feedbackAuthorDetails">
                                    <h2>Enna Serrano</h2>
                                    <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                    <p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>
                                </div>
                            </div>
                            <div class="feedbackText">
                                <div class="feedbackTextTail"></div>
                                <div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p></div>
                            </div>
                            <div class="feedbackDate">26th April 2012</div>
                        </div>
                        <div class="feedbackBlock">
                            <div class="feedbackMeta">
                                <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> -->
                                <div class="feedbackSocial">
                                    <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                    <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feedback normal">
                    <div class="feedback-branch"></div>
                    <div class="feedbackContents">
                        <div class="feedbackBlock">
                            <div class="feedbackAuthor">
                                <div class="feedbackAuthorAvatar"><img src="img/samchloe.png" width="48" height="48" /></div>
                                <div class="feedbackAuthorDetails">
                                    <h2>Sam Chloe Ranada</h2>
                                    <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                    <p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>
                                </div>
                            </div>
                            <div class="feedbackText">
                                <div class="feedbackTextTail"></div>
                                <div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p></div>
                            </div>
                            <div class="feedbackDate">26th April 2012</div>
                        </div>
                        <div class="feedbackBlock">
                            <div class="feedbackMeta">
                                <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> -->
                                <div class="feedbackSocial">
                                    <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                    <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="feedback featured">
                    <div class="feedback-branch"></div>
                    <div class="feedbackContents">
                        <div class="feedbackBlock">
                            <div class="feedbackAuthor">
                                <div class="feedbackAuthorAvatar"><img src="img/len.png" width="150" height="150" /></div>
                                <div class="feedbackAuthorDetails">
                                    <h2>Len Castor</h2>
                                    <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                    <p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>
                                </div>
                            </div>
                            <div class="feedbackText">
                                <div class="feedbackTextTail"></div>
                                <div class="feedbackTextBubble">
                                    <p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p>
                                    <p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p>
                                </div>
                            </div>
                            <div class="feedbackDate">26th April 2012</div>
                        </div>
                        <div class="feedbackBlock">
                            <div class="feedbackMeta">21 minutes ago via <a href="#">36Stories</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spine-spacer"></div>
        </div>
        <div class="feedback-date-block">
            <div class="feedback-date">
                <h2>Oct 18</h2>
                <span>2012</span>
            </div>
            <div class="feedback-spine"></div>
            <div class="spine-spacer"></div>
            <div class="the-feedbacks">
            <div class="feedback normal">
                <div class="feedback-branch"></div>
                <div class="feedbackContents">
                    <div class="feedbackBlock">
                        <div class="feedbackAuthor">
                            <div class="feedbackAuthorAvatar"><img src="img/enna.png" width="48" height="48" /></div>
                           
                            <div class="feedbackAuthorDetails">
                                <h2>Enna Serrano</h2>
                                <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                <p><span class="twitter-username"><a href="#">@realEnna</a></span></p>
                            </div>
                        </div>
                        <div class="feedbackText">
                            <div class="feedbackTextTail"></div>
                            <div class="feedbackTextBubble"><p>I love your Company! #ForestGreen</p></div>
                        </div>
                        <div class="feedbackDate">26th April 2012</div>
                    </div>
                    <div class="feedbackBlock">
                        <div class="feedbackMeta">
                            <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> -->
                            <div class="feedbackSocial">
                                <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feedback normal">
                <div class="feedback-branch"></div>
                <div class="feedbackContents">
                    <div class="feedbackBlock">
                        <div class="feedbackAuthor">
                            <div class="feedbackAuthorAvatar"><img src="img/samchloe.png" width="48" height="48" /></div>
                            <div class="feedbackAuthorDetails">
                                <h2>Sam Chloe Ranada</h2>
                                <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                <p><span class="twitter-username"><a href="#">@iamsammychu</a></span></p>
                            </div>
                        </div>
                        <div class="feedbackText">
                            <div class="feedbackTextTail"></div>
                            <div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p></div>
                        </div>
                        <div class="feedbackDate">26th April 2012</div>
                    </div>
                    <div class="feedbackBlock">
                        <div class="feedbackMeta">
                            <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> -->
                            <div class="feedbackSocial">
                                <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feedback featured">
                <div class="feedback-branch"></div>
                <div class="feedbackContents">
                    <div class="feedbackBlock">
                        <div class="feedbackAuthor">
                            <div class="feedbackAuthorAvatar"><img src="img/friendzone.png" width="150" height="150" /></div>
                            <div class="feedbackAuthorDetails">
                                <h2>Rosary Anne Matusoc</h2>
                                <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                <p><span style="float:left">New York, USA</span><span class="flag flag-ph"></span></p>
                            </div>
                        </div>
                        <div class="feedbackText">
                            <div class="feedbackTextTail"></div>
                            <div class="feedbackTextBubble">
                                <p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!"</p>
                                <p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!"</p>
                            </div>
                        </div>
                        <div class="feedbackDate">26th April 2012</div>
                    </div>
                    <div class="feedbackBlock">
                        <div class="feedbackMeta">
                            <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div>  -->
                            <div class="feedbackSocial">
                                <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                <div class="feedbackSocialFacebook"><fb:like href="http://dev.gearfish.com/hosted/single/230" send="false" layout="button_count" width="100" show_faces="false" style="float:left"></fb:like></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feedback normal">
                <div class="feedback-branch"></div>
                <div class="feedbackContents">
                    <div class="feedbackBlock">
                        <div class="feedbackAuthor"><!-- 
                            <div class="feedbackAuthorAvatar"><img src="imgenna.png" width="48" height="48" /></div>
                            -->
                            <div class="feedbackAuthorDetails">
                                <h2>Enna Serrano</h2>
                                <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                <p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>
                            </div>
                        </div>
                        <div class="feedbackText">
                            <div class="feedbackTextTail"></div>
                            <div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p></div>
                        </div>
                        <div class="feedbackDate">26th April 2012</div>
                    </div>
                    <div class="feedbackBlock">
                        <div class="feedbackMeta">
                            <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> -->
                            <div class="feedbackSocial">
                                <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feedback normal">
                <div class="feedback-branch"></div>
                <div class="feedbackContents">
                    <div class="feedbackBlock">
                        <div class="feedbackAuthor">
                            <div class="feedbackAuthorAvatar"><img src="img/samchloe.png" width="48" height="48" /></div>
                            <div class="feedbackAuthorDetails">
                                <h2>Sam Chloe Ranada</h2>
                                <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                <p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>
                            </div>
                        </div>
                        <div class="feedbackText">
                            <div class="feedbackTextTail"></div>
                            <div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p></div>
                        </div>
                        <div class="feedbackDate">26th April 2012</div>
                    </div>
                    <div class="feedbackBlock">
                        <div class="feedbackMeta">
                            <!-- <div class="feedbackTimestamp">21 minutes ago via <span><a href="#">36Stories</a></span></div> -->
                            <div class="feedbackSocial">
                                <div class="feedbackSocialTwitter"><a href="http://webmumu.com" class="twitter-share-button">Tweet</a></div>
                                <div class="feedbackSocialFacebook"><iframe src="//www.facebook.com/plugins/like.php?href=http://webmumu.com&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="feedback featured">
                <div class="feedback-branch"></div>
                <div class="feedbackContents">
                    <div class="feedbackBlock">
                        <div class="feedbackAuthor">
                            <div class="feedbackAuthorAvatar"><img src="img/len.png" width="150" height="150" /></div>
                            <div class="feedbackAuthorDetails">
                                <h2>Len Castor</h2>
                                <h4>Marketing Manager, <span>Davis LLP</span></h4>
                                <p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>
                            </div>
                        </div>
                        <div class="feedbackText">
                            <div class="feedbackTextTail"></div>
                            <div class="feedbackTextBubble">
                                <p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p>
                                <p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p>
                            </div>
                        </div>
                        <div class="feedbackDate">26th April 2012</div>
                    </div>
                    <div class="feedbackBlock">
                        <div class="feedbackMeta">21 minutes ago via <a href="#">36Stories</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spine-spacer"></div>
        </div>
    </div>
*/ ?>
    <div class="block" style="background:#ececec;text-align:center;font-size:11px;color:#a8a8a8;padding:10px 0px;">Powered by 36Stories</div>
</div>