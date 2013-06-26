<div id="theDisplayOptions" class="dashboard-page">
    <h1>Page Display Information</h1>
    <div class="dashboard-box">
        <div class="dashboard-head">
          <span class="dashboard-title">Customize your feedback page here</span>
        </div>
        <div class="dashboard-body">
            <div class="dashboard-content">
                <div class="grids">
                    <div class="display-options-list">
                        <div class="pageBody">
                        <div class="display-option-box">
                            <h2>General Items</h2>
                            <p><span class="tickerbox <?= ($settings->show_rating == 0 ? 'off' : ''); ?>" field="show_rating" display-array="stars,star_rating"></span> <span class="label">Display Rating Stars - Based on X Reviews </span></p>
                            <p><span class="tickerbox <?= ($settings->show_votes == 0 ? 'off' : ''); ?>" field="show_votes" display-array="rating-stat,vote-action"></span> <span class="label">Display 'X found this useful'</span> </p>
                            <p><span class="tickerbox <?= ($settings->show_recommendation == 0 ? 'off' : ''); ?>" field="show_recommendation" display-array="green-thumb,company-recommendation"></span> <span class="label">Display 'Recommended to friends' text</span> </p>
                            
                            <h2>Display Meta Information</h2>
                            <p><span class="tickerbox <?= ($settings->show_metadata == 0 ? 'off' : ''); ?>" field="show_metadata" display-array="custom-meta-data"></span> <span class="label">Display Custom Field</span> </p>
                            
                            <h2>Display Admin Comment</h2>
                            <p><span class="tickerbox <?= ($settings->show_admin_comment == 0 ? 'off' : ''); ?>" field="show_admin_comment" display-array="admin-comment-block"></span> <span class="label">Disable or enable public admin commenting</span> </p>
                            
                            <h2>Sharing Options</h2>
                            <p><span class="tickerbox <?= ($settings->show_sharing_option == 0 ? 'off' : ''); ?>" field="show_sharing_option" display-array="share-icon"></span> <span class="label">Enable Feedback sharing options by Facebook/Twitter</span> </p>
                            
                            <h2>Display 'Flag as inappropriate' Option</h2>
                            <p><span class="tickerbox <?= ($settings->show_flag_inapp == 0 ? 'off' : ''); ?>" field="show_flag_inapp" display-array="flag-as-inapp"></span> <span class="label">Allows users to report inappropiate feedback to your administrative team</span> </p>
                            
                            <h2>User Display Information</h2>
                            <p><span class="tickerbox <?= ($settings->show_avatar == 0 ? 'off' : ''); ?>" field="show_avatar" display-array="author-avatar"></span> <span class="label">Display Avatar</span> </p>
                            <p><span class="tickerbox <?= ($settings->show_last_name_as_ini == 0 ? 'off' : ''); ?>" field="show_last_name_as_ini" display-array="last_name_ini"></span> <span class="label">Display Last Name as initial</span> </p>
                            <p><span class="tickerbox <?= ($settings->show_position == 0 ? 'off' : ''); ?>" field="show_position" display-array="job"></span> <span class="label">Display Job Position</span> </p>
                            <p><span class="tickerbox <?= ($settings->show_company == 0 ? 'off' : ''); ?>" field="show_company" display-array="company,company_comma"></span> <span class="label">Display Company Name</span> </p>
                            <p><span class="tickerbox <?= ($settings->show_city == 0 ? 'off' : ''); ?>" field="show_city" display-array="city"></span> <span class="label">Display City</span> </p>
                            <p><span class="tickerbox <?= ($settings->show_country == 0 ? 'off' : ''); ?>" field="show_country" display-array="country,location_comma"></span> <span class="label">Display Country</span> </p>
                            <p><span class="tickerbox <?= ($settings->show_flag == 0 ? 'off' : ''); ?>" field="show_flag" display-array="flag"></span> <span class="label">Display Country Flag</span> </p>
                            
                            <h2>Attachment Options</h2>
                            <p><span class="tickerbox <?= ($settings->show_image_attachment == 0 ? 'off' : ''); ?>" field="show_image_attachment" display-array="uploaded-images"></span> <span class="label">Display Image Attachments</span> </p>
                            <p><span class="tickerbox <?= ($settings->show_video_attachment == 0 ? 'off' : ''); ?>" field="show_video_attachment" display-array="uploaded-link,uploaded-video"></span> <span class="label">Display Video Attachments</span> </p>
                        </div>
                    </div>
                    </div>
                    <div class="display-options-view">
                        <div id="adminDisplayOptionAuthorItems" class="display-feedback-block">
                        
                            <div class="display-author clear">
                                <div class="author-avatar">
                                    <img src="/img/48x48-blank-avatar.jpg" width="48" height="48"/>
                                </div>
                                <div class="author-information">
                                    <div class="author-name clear">
                                        <span class="first_name">John</span>
                                        <span class="last_name">Doe</span>
                                        <span class="last_name_ini">D.</span>
                                    </div>
                                    <div class="author-company">
                                        <span class="job">Marketing<span class="company_comma">,</span></span>
                                        <span class="company">ACME</span>
                                    </div>
                                    <div class="author-location-info clear">
                                        <div class="author-location">
                                            <span class="city">Quezon City<span class="location_comma">,</span></span>
                                            <span class="country">Philippines </span>
                                        </div>
                                        <div class="flag flag-ph"></div>
                                    </div>
                                    <div class="custom-meta-data break-word clear">
                                        <div class="meta-data">
                                            <span class="meta-name">Pet Type : </span>
                                            <span class="meta-value">Dog</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rating-stars-container">
                                    <div class="display-author-date">3 Months Ago</div>
                                    <div class="stars blue clear">
                                        <div class="star full"></div>
                                        <div class="star full"></div>
                                        <div class="star full"></div>
                                        <div class="star full"></div>
                                        <div class="star half"></div>    
                                    </div>
                                </div>
                            </div>
                            
                            <div class="feedback-text-bubble">
                                <div class="feedback-tail"></div>
                                <div class="rating-stat">
                                    <span class="vote_count">98</span> people found this useful
                                </div>
                                <div class="feedback-text">
                                    I would like to give you a two thumbs up for the services that you have provided to me and my dog BunBun
                                </div>
                                <div class="additional-contents">
                                    <div class="uploaded-images clear">
                                        <div class="uploaded-image">
                                            <div class="padded-5">
                                                <div class="the-thumb">
                                                    <img src="https://petopia.fdback.com/uploaded_images/form_upload/small/bd74f13dd21cd41996d64a50f3800281.jpg" width="100%" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uploaded-image">
                                            <div class="padded-5">
                                                <div class="the-thumb">
                                                    <img src="https://petopia.fdback.com/uploaded_images/form_upload/small/59ddf568895a4269733e65f73b5105aa.jpg" width="100%" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uploaded-image">
                                            <div class="padded-5">
                                                <div class="the-thumb">
                                                    <img src="https://petopia.fdback.com/uploaded_images/form_upload/small/77658ef90dd2a92ddb4eae24303a22ea.jpg" width="100%" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uploaded-link">
                                        <div class="padded-5">
                                            <div class="form-video-meta">
                                                <div class="video-thumb">
                                                    <div class="video-circle"></div>
                                                    <div class="the-thumb">
                                                        <img src="http://i2.ytimg.com/vi/hzNmbzhQ6Wc/hqdefault.jpg" width="100%" />
                                                    </div>
                                                </div>
                                                <div class="video-details">
                                                    <h3>Black Pug Puppy</h3>
                                                    <p>My Black Pug loves carrots! But he is not very good at catchin...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="admin-comment-block">
                                    <div class="admin-comment">
                                        <div class="admin-name"></div>
                                        <div class="admin-message clear">
                                            <div class="admin-avatar">
                                            <img src="/img/48x48-blank-avatar.jpg" width="32" height="32"></div>
                                            <div class="message">We love customers like you - come back again soon!</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="feedback-options clear">
                                <div class="feedback-icon-list clear">
                                    <div class="feedback-recommendation">
                                        <div class="green-thumb">Recommended by John to friends</div>
                                        <div class="vote-block">
                                            <span class="vote-action ">
                                                Was this useful? <a href="#" class="small-btn-pin">Yes</a>
                                            </span>
                                        </div>
                                    </div>
                                    <div style="float: right;">
                                        <div class="flag-feedback feedback-icon flag-feedback-fancy" fid="5708">
                                            <div id="flag-feedback-icon-5708" class="feedback-icon-class flag-icon flag-as-inapp"></div>
                                            <div class="icon-tooltip">
                                                <div class="icon-tooltip-text">
                                                    Flag as Inappropriate
                                                </div>
                                                <div class="icon-tooltip-tail"></div>
                                            </div>
                                        </div>
                                        <div class="feedback-icon">
                                            <div class="feedback-icon-class share-icon"></div>
                                            <div class="icon-tooltip">
                                             <div class="icon-tooltip-text">Share</div>
                                                <div class="icon-tooltip-tail"></div>
                                            </div>
                                            <div class="share-box">
                                                <div class="share-box-arrow"></div>
                                                <div class="btn-block">
                                                    <div class="fb_like_dummy" data-href="https://petopia.fdback.com/single/5708" data-layout="button_count" data-send="false" data-width="80" data-show-faces="false"></div>
                                                </div>
                                                <!-- <div class="btn-block">
                                                    <a href="https://petopia.fdback.com/single/5708" data-url="https://petopia.fdback.com/single/5708" data-text="Thanks to Petopia, I gained a significant understanding of my dog's health concerns. I went for a visit to treat my poodle to a spa treatment and I decided  to have him checked too, as suggested by your staff. I never knew that poodles required extra care, being a new pet owner, and I was extremely happy to learn that poodles are often cited as a hypoallergenic dog breed. Your pet professionals told me that the poodle's individual hair follicles have an active growth period that is longer than that of many other breeds of dogs; combined with the tightly curled coat, which slows the loss of dander and dead hair by trapping it in the curls, an individual poodle may release less dander and hair into the environment. In addition, I learned that it does not help that I frequently brush and bathe my dog to keep them looking their best; this not only removes hair and dander but also controls the other potent allergen, saliva. Thank you Petopia for giving me the best possible advice on how to take care of my pet's health! Now my dog is very healthy, no allergies at all! " class="tw_share_dummy">Tweet</a>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= HTML::script('/fullpage/admin/js/Settings.js'); ?>
<?= HTML::script('/fullpage/admin/js/SettingsAutoSaver.js'); ?>
<script type="text/javascript">
    Settings.init();
    SettingsAutoSaver.init();
</script>