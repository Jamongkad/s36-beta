<div id="mainWrapper">
	<div id="fadedContainer">
    	<div id="mainContainer">
            <div id="coverPhotoContainer">
                <div id="coverPhoto">
                    <img src="img/sample-cover.jpg" />
                </div>
            </div>
           
            <div class="hosted-block">
                <div class="company-description clear">
                    <div class="company-text"><?=$company->description?></div>
                    <div class="send-button"><a href="<?=$company->company_name?>/submit">Send in feedback</a></div>
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
            
            <div id="feedbackContainer">
                <div id="timelineLayout">
                    <!-- blocks are separated by dates so we create containers for each dates -->
                    <?php 
                    if($feeds): //if feed exist
                    foreach ($feeds as $feed_group => $feed_list) : //start feedback group loop
                    ?>
                    <div class="feedback-block">
                        <div class="feedback-spine"></div>                
                        <div class="spine-spacer"></div>
                        <div class="feedback-date">
                            <h2><?=date('M d',$feed_group)?></h2>
                            <span><?=ucfirst(Helpers::relative_time($feed_group))?></span>
                        </div>
                        <div class="spine-spacer"></div>
                        <div class="feedback-list">
                            <?php
                            foreach ($feed_list as $feed) : 
                                $feedback_main_class        = ($feed->feed_data->isfeatured == 1) ? 'regular-featured' : 'regular';
                                $feedback_content_class     = ($feed->feed_data->isfeatured == 1) ? 'regular-featured-contents' : 'regular-contents';
                                $tw_marker                  = ($feed->feed_data->origin=='tw') ? '<div class="twitter-marker"></div>' : '';
                                $author_name                = $feed->feed_data->firstname.' '.$feed->feed_data->lastname;
                                $author_company             = $feed->feed_data->position.', '.$feed->feed_data->companyname;
                                $author_location            = $feed->feed_data->city.', '.$feed->feed_data->countryname;
                                $text                       = $feed->feed_data->text;
                            ?>
                            <div class="feedback <?=$feedback_main_class?>">
                                <?=$tw_marker?>
                                <div class="<?=$feedback_content_class?>">
                                    <!-- feedback header -->
                                    <div class="feedback-header clear">
                                        <div class="author">
                                            <div class="author-avatar"><img src="<?=$feed->feed_data->avatar?>" width="48" height="48" /></div>   
                                            <div class="author-information">
                                                <div class="author-name clear"><?=$author_name?></div>
                                                <div class="author-company"><?=$author_company?></div>
                                                <div class="author-location-info clear">
                                                    <div class="author-location"><?=$author_location?></div><div class="flag flag-<?=strtolower($feed->feed_data->countrycode)?>"></div>
                                                </div>
                                                <div class="custom-meta-data clear">
                                                    <!--
                                                    <div class="meta-data"><span class="meta-name">Product Purchased : </span><span class="meta-value"> Spaghetti Bolognese</span></div>
                                                    <div class="meta-data"><span class="meta-name">Quality : </span><span class="meta-value"> Excellent</span></div>
                                                    -->
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="reviews clear">
                                            <div class="ratings">
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
                                        <div class="feedback-text">
                                            <p><?=$text?></p>                                            
                                        </div>
                                        <div class="additional-contents">
                                            <!-- is it an image? -->
                                            <div class="uploaded-images clear">
                                                <div class="uploaded-image">
                                                    <div class="padded-5">
                                                        <img src="img/sample.jpg" width="100%" />
                                                    </div>
                                                </div>
                                                <div class="uploaded-image">
                                                    <div class="padded-5">
                                                        <img src="img/sample.jpg" width="100%" />
                                                    </div>
                                                </div>
                                                <div class="uploaded-image">
                                                    <div class="padded-5">
                                                        <img src="img/sample-bg.jpg" width="100%" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- a video -->
                                            <div class="uploaded-video">
                                                <div class="padded-5">
                                                    <iframe width="293" height="220" src="" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                            <!-- or just a preview link? -->
                                            <div class="uploaded-link">
                                                <div class="padded-5">
                                                    <div class="form-video-meta">
                                                        <div class="video-thumb">
                                                            <img src="http://i2.ytimg.com/vi/e9iDr1kFZDo/hqdefault.jpg" width="100%">
                                                        </div>
                                                        <div class="video-details">
                                                            <h3>Happy Tree Friends - Remains To Be See...</h3>
                                                            <p>Watch the NEW Happy Tree Friends episode "Bottled Up"! (Model ship not included) - http://bit.ly/UnwakV Do you want extra exclusive content? Circle us on Goo...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="admin-comment-block">
                                            <div class="admin-name">Amy from Acme Inc says..</div>
                                            <div class="admin-message clear">
                                                <div class="admin-avatar"><img src="img/samchloe.png" width="32" height="32" /></div>
                                                <div class="message">Great choice!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of feedback text bubble -->
                                    <!-- feedback user actions -->
                                    <div class="feedback-options clear">
                                        <div class="feedback-recommendation">
                                            <div class="green-thumb">Recommended by Leica to friends</div>
                                            <div class="vote-block">
                                                <span class="vote-action">Was this useful? <a href="#" class="small-btn-pin">Yes</a> <a href="#" class="small-btn-pin">No</a></span>
                                            </div>
                                        </div>
                                        <div class="feedback-actions clear">
                                            <span class="flag-as">Flag as inappropriate</span>
                                            <span class="share-button">Share</span>
                                        </div>    
                                    </div>
                                    <!-- end of feedback user actions -->
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                    endforeach; //end loop for feedback group
                    endif; //end if feed exists
                    ?>
                </div>
            </div>
</div>
</div>
</div>