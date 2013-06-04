<?php
    $db_fullpage_cover = new \Hosted\Repositories\DBFullpageCover(Config::get('application.subdomain'));
    $fullpage_cover = $db_fullpage_cover->get_data();
?>
<div id="coverPhotoContainer">
    <?php if( ! is_null($fullpage_cover->user) ): ?>
        <div id="changeCoverButtonIcon">
            <div id="coverMenuList">
                <ul>
                    <li id="coverChange">
                        Change cover photo
                        <input type="file" id="cv_image" data-url="/imageprocessing/upload_coverphoto" style="" />
                    </li>
                    <li id="coverReposition" style="<?= ( is_null($fullpage_cover->coverphoto_src) ? 'display: none;' : '' ); ?>">
                        Reposition
                    </li>
                    <li id="coverRemove" style="<?= ( is_null($fullpage_cover->coverphoto_src) ? 'display: none;' : '' ); ?>">
                        Remove
                    </li>
                </ul>
            </div>
        </div>
        <div id="dragPhoto">Drag Image to Reposition Cover</div>
        <div id="coverActionButtons">
            <ul>
                <li><a id="save_cover_photo" href="javascript:;">Save</a></li>
                <li><a id="cancel_cover_photo" href="javascript:;">Cancel</a></li>
            </ul>
        </div>
    <?php endif; ?>
    
    <div id="coverPhoto">
        <?php if( ! is_null($fullpage_cover->user) ): ?>
            <?php $src = ( is_null($fullpage_cover->coverphoto_src) ? '/img/sample-cover.jpg' : '/uploaded_images/coverphoto/' . $fullpage_cover->coverphoto_src . '?' . str_shuffle('GetRidOfCache') ); ?>
            <input type="hidden" id="hidden_cover_photo" src="<?php echo $src; ?>" style="top: <?php echo (int)$fullpage_cover->coverphoto_top; ?>px; position: relative;" />
        <?php endif; ?>
        
        <?php if( ! is_null($fullpage_cover->coverphoto_src) ): ?>
            <img width="850px" dir="/uploaded_images/coverphoto/" basename="" src="/uploaded_images/coverphoto/<?php echo $fullpage_cover->coverphoto_src . '?' . str_shuffle('GetRidOfCache'); ?>" style="top: <?php echo $fullpage_cover->coverphoto_top; ?>px; position: relative;" />
        <?php else: ?>
            <?php if( ! is_null($fullpage_cover->user) ): ?>
                <img dir="/uploaded_images/coverphoto/" basename="" src="/img/sample-cover.jpg" />
            <?php else: ?>
                <img width="850px" src="/img/public-coverphoto.jpg" />
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    
    <!-- social link icons 1/28/2013 -->
    <div id="socialLinkIcons" class="clear">
        <div class="social-icon fb" style="display: <?= (trim($fullpage_cover->facebook_url) == '' ? 'none' : ''); ?>;">
            <a id="fb_url" href="<?= $fullpage_cover->facebook_url; ?>" target="_blank">
                <img src="/fullpage/common/img/facebook.png" title="Facebook Page" />
            </a>
        </div>
        <div class="social-icon tw" style="display: <?= (trim($fullpage_cover->twitter_url) == '' ? 'none' : ''); ?>;">
            <a id="tw_url" href="<?= $fullpage_cover->twitter_url; ?>" target="_blank">
                <img src="/fullpage/common/img/twitter.png" title="Twitter Page" />
            </a>
        </div>
    </div>
    
    
    <!-- profile pic -->
    <div id="avatarContainer">
        <?php if( ! is_null($fullpage_cover->user) ): ?>
            <?php $src = ( empty($fullpage_cover->logo) ? '/img/public-profile-pic.jpg' : '/uploaded_images/company_logos/main/' . $fullpage_cover->logo . '?' . str_shuffle('GetRidOfCache') ); ?>
            <input type="hidden" id="hidden_company_logo" src="<?php echo $src; ?>" />
            <input type="hidden" id="company_id" value="<?php echo $fullpage_cover->user->companyid; ?>" />
        <?php endif; ?>
        
        <?php if( ! empty($fullpage_cover->logo) ): ?>
            <img basename="" src="/uploaded_images/company_logos/main/<?php echo $fullpage_cover->logo . '?' . str_shuffle('GetRidOfCache'); ?>" />
        <?php else: ?>
            <img basename="" src="/img/public-profile-pic.jpg" width="100%" />
        <?php endif; ?>
        
        <?php if( ! is_null($fullpage_cover->user) ): ?>
            <div id="avatarButtonIcon">
                <div id="avatarMenuList">
                    <ul>
                        <li>
                            Change Photo
                            <input type="file" id="company_logo" data-url="/imageprocessing/upload_company_logo" />
                        </li>
                        <li id="remove_logo" style="<?php echo ( empty($fullpage_cover->logo) ? 'display: none;' : '' ); ?>">
                            Remove
                        </li>
                    </ul>
                </div>
            </div>
            <div id="logoActionButtons">
                <ul>
                    <li><a id="save_company_logo" href="javascript:;">Save</a></li>
                    <li><a id="cancel_company_logo" href="javascript:;">Cancel</a></li>
                </ul>                   
            </div>
        <?php endif; ?>
    </div>
</div>
<?= HTML::style('/fullpage/admin/css/FullpageCover.css'); ?>
<?= HTML::script('/fullpage/admin/js/FullpageCover.js'); ?>
<script type="text/javascript">
    fullpage_cover = new FullpageCover();
    fullpage_cover.init();
</script>