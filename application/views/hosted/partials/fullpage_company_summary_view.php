<!-- start of rich snippets. -->
<div itemscope itemtype="https://data-vocabulary.org/Review-aggregate">
    <meta itemprop="itemreviewed" content="<?php echo $company->company_name; ?>" />
    <meta itemprop="summary" content="<?php echo $company->description; ?>" />
    <meta itemprop="count" content="<?php echo $company->total_feedback; ?>" />
    <meta itemprop="rating" content="<?php echo round($company->avg_rating); ?>" />
</div>
<!-- end of rich snippets. -->

<div id="companySummaryContainer">
    
    <div class="hosted-block">
        <div class="company-rating">
            <!--<div class="company-cover-name break-word"><h1><?=ucfirst($company->company_name)?></h1></div>-->
            <div class="dynamic-stars-container">
                <div class="dynamic-stars">
                    <div class="star-ratings clear">
                        <div class="star-container clear">
                            <input type="hidden" id="company_rating" value="<?php echo round($company->avg_rating); ?>" /><? // used in reseting rating. ?>
                            <input type="hidden" id="rating" name="rating" value="<?php echo round($company->avg_rating); ?>" />
                            <div id="1" class="star <?= (round($company->avg_rating) >= 1 ? 'full' : ''); ?>"></div>
                            <div id="2" class="star <?= (round($company->avg_rating) >= 2 ? 'full' : ''); ?>"></div>
                            <div id="3" class="star <?= (round($company->avg_rating) >= 3 ? 'full' : ''); ?>"></div>
                            <div id="4" class="star <?= (round($company->avg_rating) >= 4 ? 'full' : ''); ?>"></div>
                            <div id="5" class="star <?= (round($company->avg_rating) >= 5 ? 'full' : ''); ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="review-count">
                <strong>Based on <?php echo $company->total_feedback; ?> reviews.</strong>
                <?$regex = Helpers::nav_regex();?>
                <?php if( $regex->home || $regex->single ): ?>
                    Rate us!
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="hosted-block">
        <div class="company-description clear">
            <div class="company-text">
                <div class="company-text-content">
                    <? // keep the content of #fullpage_desc and #def_desc in one line. ?>
                    <div id="def_desc" style="display: none;">Thanks for viewing <?= ucfirst( HTML::entities($company->company_name) ); ?>'s customer reviews and testimonials. Feel free to rate us now by clicking on the Stars on the left to get started!</div>
                    
                    <?php if( trim($company->description) != '' ): ?>
                        <div id="fullpage_desc" class="break-word"><?= nl2br( Helpers::urls_to_links(HTML::entities( substr($company->description, 0, 500) )) ); ?></div>
                    <?php else: ?>
                        <div id="fullpage_desc" class="break-word">Thanks for viewing <?=ucfirst($company->company_name)?>'s customer reviews and testimonials. Feel free to rate us now by clicking on the Stars on the left to get started!</div>
                    <?php endif; ?>
                    
                    <?php if( ! is_null($user) ): ?>
                        <textarea id="fullpage_desc_textbox" rows="3" maxlength="500"></textarea>
                        <div id="desc_edit_icon"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div> <!-- end of .hosted-block (ratings and description) -->
    
    
    <? // here's our new fullpage form. ?>
    <?= $widget_loader->load()->render_hosted(); ?>
        
    <div class="hosted-block">
        <div class="company-reviews clear">
            <div class="company-recommendation">
                <?php if( $company->total_feedback != 0 ): ?>
                    <div class="green-thumb">
                        <?php echo round(($company->total_recommendations / $company->total_feedback) * 100); ?>% 
                        of our customers recommend us to their friends.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div> <!-- end of .hosted-block (recommendation) -->
    
</div><!-- end of #companySummaryContainer -->
