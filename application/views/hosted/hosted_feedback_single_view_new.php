<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hosted Page Timeline Layout</title>
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
        <meta property="og:title" content="<?=strip_tags($feedback->title)?>"/> 
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
        /*
        |--------------------------------------------------------------------------
        | Facebook Open Graph
        |--------------------------------------------------------------------------
        */
        ?>
        <?= HTML::style('/fullpage/common/css/S36SinglePage.css'); ?>
        <?= HTML::style('/fullpage/common/css/S36SingleCommon.css'); ?>
        <?= HTML::style('/fullpage/common/css/override.css');  // moved here from application/views/partials/fullpage_header.php. ?>

        <?= HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'); ?>
        <?= HTML::script('https://platform.twitter.com/widgets.js" type="text/javascript'); ?>
</head>
<body>
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
            <div class="hosted-block">
                <div class="company-description clear">
                    <div class="company-text">
                       Our company strives to bring only the best possible products and services suitable for our clients specific needs. <br />
                       Our business is simple: you describe, we create. Visit us at  www.charleskeith.com today and experience the love. 
                    </div>
                    <div class="send-button">
                        <a href="javascript:reload_masonry();">Send in feedback</a>
                    </div>
                </div>
            </div>
            
            <div class="hosted-block">
                <div class="company-reviews clear">
                    <div class="company-recommendation">
                        <div class="green-thumb">98% of our customers recommend us to their friends.</div>
                    </div>
                    <div class="company-rating">
                        <div class="review-count">Based on 29 reviews</div>
                        <div class="stars blue clear">
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star half"></div>    
                        </div>
                        
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
            	<!-- this is where the magic begins -->
                <div id="threeColumnLayout"> 
                    <div class="feedback-list">
                        <div class="feedback regular-featured">
                            <div class="twitter-marker"></div>
                            <div class="regular-featured-contents">
                                <!-- feedback header -->
                                <div class="feedback-header clear">
                                    <div class="author">
                                        <div class="author-avatar"><img src="img/samchloe.png" width="48" height="48" /></div>	
                                        <div class="author-information">
                                            <div class="author-name clear"><span class="first_name">Sam Chloe</span> <span class="last_name">Ranada</span></div>
                                            <div class="author-company"><span class="job">Marketing</span><span class="company_comma">,</span> <span class="company">BMW Singapore</span></div>
                                            <div class="author-location-info clear">
                                                <div class="author-location"><span class="city">Quezon City</span><span class="location_comma">,</span> <span class="country">Philippines</span></div><div class="flag flag-ph"></div>
                                            </div>
                                        </div>	
                                    </div>
                                    <div class="reviews clear">
                                        <div class="ratings clear">
                                            <div class="feedback-timestamp">Posted 3 hours ago</div>
                                            <div class="stars blue clear">
                                                <div class="star full"></div>
                                                <div class="star full"></div>
                                                <div class="star full"></div>
                                                <div class="star full"></div>
                                                <div class="star half"></div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of feedback header -->
                                
                                <!-- feedback text bubble -->
                                <div class="feedback-text-bubble">
                                    <div class="feedback-tail"></div>
                                    <div class="rating-stat">87 of 98 people found this useful</div>
                                    <div class="custom-meta-data clear">
                                        <div class="meta-data"><span class="meta-name">Product Purchased : </span><span class="meta-value"> Spaghetti Bolognese</span></div>
                                        <div class="meta-data"><span class="meta-name">Quality : </span><span class="meta-value"> Excellent</span></div>
                                    </div>
                                    <div class="feedback-text">
                                        <p>Our company strives to bring only the best possible products and services suitable for our clients specific needs. Our business is simple: you describe, we create. Visit us at www.charleskeith.com today and experience the love.</p>
                                    </div>
                                    <!-- are there any additional info uploaded?? -->
                                    <div class="additional-contents">
                                        <!-- is it an image? -->
                                         
                                        <div class="uploaded-video">
                                            <div class="padded-5">
                                                <iframe width="717" height="346" src="http://www.youtube.com/embed/e9iDr1kFZDo" frameborder="0" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                        <!-- or just a preview link? -->
                                        
                                    </div>

                                    <div class="admin-comment-block">
                                        <div class="admin-comment-box">
                                            <div class="admin-comment-textbox-container">
                                                <textarea class="admin-comment-textbox"></textarea>
                                            </div>
                                            <div class="admin-comment-leave-a-reply">
                                                <span class="admin-logged-session">Logged in as <a href="#">Chris Davidson</a></span><input type="button" class="regular-button" value="Post Comment" />
                                            </div>
                                        </div>

                                        <div class="admin-comment">
                                            <div class="admin-name">Amy from Acme Inc says..</div>
                                            <div class="admin-message clear">
                                                <div class="admin-avatar"><img src="fullpage/common/img/samchloe.png" width="32" height="32" /></div>
                                                <div class="message">Great choice!</div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <br />
                                </div>
                                <!-- end of feedback text bubble -->
                                <!-- feedback user actions -->
                                <div class="feedback-options clear">
                                    <div class="feedback-recommendation">
                                        <div class="green-thumb">Recommended by Leica to friends</div>
                                    </div>
                                    <div class="feedback-vote">
                                        <span class="vote-action">Was this useful? <a href="#" class="small-btn-pin">Yes</a> <a href="#" class="small-btn-pin">No</a></span>
                                    </div>
                                    <div class="feedback-actions clear">
                                        <span class="flag-as">Flag as inappropriate</span>
                                        <span class="share-button">
                                            Share
                                            <div class="share-box">
                                                <div class="share-box-arrow"></div>
                                                <div class="btn-block">
                                                    facebook
                                                </div>
                                                <div class="btn-block">
                                                    twitter
                                                </div>
                                                <div class="btn-block">
                                                    google+
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
                <!-- end of magic -->
            </div>
            <p align="center"><img src="img/36stories-logo.png" /></p>
        </div>
    </div>
</div>
</body>
</html>
