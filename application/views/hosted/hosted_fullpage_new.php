<?= HTML::script('/js/jquery.raty.min.js'); ?>
<?= HTML::style('css/override.css'); ?>

<script type="text/javascript">
    
    // general functions.
    
    // convert \n to br tags.
    function nl2br(s){
        return s.replace(/\n/g,'<br>');
    }
    
    // convert br tags to \n.
    function br2nl(s){
        return s.replace(/<br ?\/?>/g,'\n');
    }
    
    // convert html to entities.
    function html2entities(s){
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
    
    // convert entities to html.
    function entities2html(s){
        return s.replace(/&amp;/g,'&').replace(/&lt;/g,'<').replace(/&gt;/g,'>');
    }
    
    
    
    $(document).ready(function(){
        
        // start of jquery raty.
        
        $('.star_rating').raty({
            hints: ['BAD', 'POOR', 'AVERAGE', 'GOOD', 'EXCELLENT'],
            score: function(){
                return $(this).attr('rating');
            },
            path: '/img/',
            starOn: 'star-fill.png',
            starOff: 'star-empty.jpg',
            readOnly: true
        });
        
        // end of jquery raty. 
        
        
        
        // start of description ajax edit.
        
        $('.company-text').hover(
            function(){
                if( $('#desc_textbox_con').css('display') != 'block' ){
                    $('.edit').css('display', 'inline-block');
                }
            },
            function(){
                $('.edit').css('display', 'none');
            }
        );
        
        $('.edit').click(function(){
            $('.edit').css('display', 'none');
            $('.save, .cancel').css('display', 'inline-block');
            $('#desc_text').css('display', 'none');
            $('#desc_textbox_con').css('display', 'block');
        });
        
        $('.cancel').click(function(){
            $('.edit').css('display', 'none');
            $('.save, .cancel').css('display', 'none');
            $('#desc_textbox_con').css('display', 'none');
            $('#desc_text').fadeIn();
            $('#desc_textbox').val( entities2html( br2nl($('#desc_text').html().replace(/\n/g,'')) ) );
        });
        
        $('.save').click(function(){
            
            var data = {};
            data['description'] = $('#desc_textbox').val();
            
            $.ajax({
                url: '/update_desc',
                type: 'post',
                data: data,
                success: function(result){
                    // if result returned 1, it means he's not logged in.
                    if( result == 1 ){
                        alert('You should be logged in to do this action');
                    }else{
                        $('#desc_text').html( nl2br( html2entities($('#desc_textbox').val()) ) );
                        $('.cancel').trigger('click');
                    }
                }
            });
            
        });
        
        // end of description ajax edit.
        
    });
    
</script>

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
                    <div class="company-text">
                        <div id="desc_text"><?= nl2br( HTML::entities($company->description) ); ?></div>
                        <?php if( ! is_null($user) ): ?>
                            <div id="desc_textbox_con">
                                <textarea id="desc_textbox" rows="3"><?=$company->description?></textarea>
                            </div>
                            <div id="action_buttons">
                                <div class="edit action_button" title="Edit"></div>
                                <div class="save action_button" title="Save"></div>
                                <div class="cancel action_button" title="Cancel"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="send-button"><a href="javascript:;">Send in feedback</a></div>
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
                        <div class="review-count">Based on <?php echo $company->total_feedback; ?> reviews</div>
                        <div class="stars blue clear"><div class="star_rating" rating="<?php echo round($company->avg_rating); ?>"></div></div>
                        <!--
                        <div class="stars blue clear">
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star full"></div>
                            <div class="star half"></div>    
                        </div>
                        -->
                    </div>
                </div>
            </div>
            
            <div id="feedbackContainer">
                <div id="timelineLayout">
                    <!-- blocks are separated by dates so we create containers for each dates -->
                    <?php
                    if($feeds):
                    //echo "<pre>";print_r($feeds); echo "</pre>";
                    foreach ($feeds as $feed_group => $feed_list) : 
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
                                $attachments                = (!empty($feed->feed_data->attachments)) ? json_decode($feed->feed_data->attachments) : false;
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

                                    <?php if($attachments): ?>
                                        <div class="additional-contents">
                                        <!-- is it an image? -->
                                        <?php if(isset($attachments->uploaded_images)): ?>
                                            <div class="uploaded-images clear">
                                                <?php foreach($attachments->uploaded_images as $uploaded_image): ?>
                                                <div class="uploaded-image">
                                                    <div class="padded-5">
                                                        <img src="<?=$uploaded_image->small_url?>" width="100%" />
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if(isset($attachments->attached_link)): ?>
                                            <!-- a video -->
                                            <?php /*
                                            <div class="uploaded-video">
                                                <div class="padded-5">
                                                    <iframe width="293" height="220" src="" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                            */ ?>
                                            <!-- or just a preview link? -->
                                            <div class="uploaded-link">
                                                <div class="padded-5">
                                                    <div class="form-video-meta">
                                                        <div class="video-thumb">
                                                            <img src="<?=$attachments->attached_link->image?>" width="100%">
                                                        </div>
                                                        <div class="video-details">
                                                            <h3><?=$attachments->attached_link->title?></h3>
                                                            <p><?=$attachments->attached_link->description?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

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
                    endforeach;
                    endif;
                    ?>
                </div>
            </div>
</div>
</div>
</div>