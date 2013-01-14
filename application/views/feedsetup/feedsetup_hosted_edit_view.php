<?=Form::open_for_files('feedsetup/update_hosted_settings', 'POST', Array('id' => 'update-hosted'))?>
<?=Form::hidden('company_id', $hosted_full_page->companyid)?>
<?=Form::hidden('theme_name', $hosted_full_page->theme_name, Array('id' => 'selected-form'))?>
<script type="text/javascript">
    jQuery(function($) {
        $("#hosted_bg_img").aeImageResize({ height: 250, width: 250 });
    });
</script>

<div>
    <div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
        <h3>HOSTED FEEDBACK DISPLAY SETUP</h3>
    </div>
    <div class="block noborder">
        <div id="hosted-wizard">
            <div id="hosted-wizard-step-1" class="wizard-steps current">
                <strong>Choose your theme</strong><br />                
                <div class="grids">
                    <div class="">
                        <?php /*
                        <select class="regular-select" id="theme-select">
                            <?foreach($main_themes as $main_theme):?>
                                <option value="<?=$main_theme?>" <?=($themes_parent == $main_theme) ? 'selected' : null?>><?=ucwords($main_theme)?></option>
                            <?endforeach?>
                        </select>
                        */ ?>
                        <!--<input type="hidden" value="1" id="selected-theme" name="selected-theme" />-->
                        <!--<a href="#">View all Categories</a>-->
                        <div class="grids">
                        <br />
                        <div id="asdf" class="form-design-slide" style="margin-left: -10px; display: block; ">
                            <!-- <div class="form-design-prev" style="margin-top:15px;"></div> -->
                            <div class="form-designs grids">                                            
                            <div class="form-design-group grids">
                                <?php foreach($themes as $theme): ?>
                                <div class="form-design" id="<?=$theme->theme_name?>">
                                    <img src="/img/display-thumb.png ">
                                    <br>
                                    <span><?=ucfirst($theme->theme_name)?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            </div>
                            <!-- <div class="form-design-next" style="margin-top:15px;"></div> -->
                        </div>
                            <?php /*
                            <div id="minimalist" class="form-design-slide" style="margin-left:-10px;display:none;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >                                                               
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->minimalist->children, 'data_type' => null))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                            <div id="creative" class="form-design-slide" style="margin-left:-10px;display:none;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >                                                               
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->creative->children, 'data_type' => null))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                            */ ?>
                        </div>
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
            </div>

            <div id="hosted-wizard-step-2123" class="wizard-steps">
               <div class="grids">
                    <div class="g2of3"><strong>Choose a Background Image</strong> <br>
                        <?if($background_image = $hosted_full_page->background_image):?>
                            You already have an existing background image. If you want to replace it, choose a replacement background image via the 'Browse...' button and to save press the 'Save Settings' 
                            button.<br/>
                            <img src="/uploaded_images/hosted_background/<?=$background_image?>" id="hosted_bg_img"/>
                        <?else:?>
                            Select your company's background image for the fullpage, it will be uploaded upon pressing the 'Save Settings' button.
                        <?endif?>
                    </div>
                    <div class="g2of3"><br><input type="file" id="hosted_background" class="fileupload regular-text" name="hosted_background"> </div>
                </div>
            </div>
            <!--   
            <div id="hosted-wizard-step-2" class="wizard-steps">
                <div class="grids">
                    <div class="g3of4">
                        <strong>Configure your feedback header text</strong><br/>
                        Configure your hosted page to suit your website and theme - you can direct visitors to your hosted page to view existing published feedback, or to get them to send in feedback.
                        <input type="text" name="header_text" value="<?=$hosted_full_page->header_text?>" id="header-text" class="wizard-text-field" 
                               title="Hear what our customers have to say" />
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
                <div class="grids" style="height:285px">
                    <img src="/img/hosted-display-preview.jpg" />
                </div>
            </div>
            <div id="hosted-wizard-step-3" class="wizard-steps">
                <div class="grids">
                    <div class="g3of4">
                        <strong>Customize your submission form header title</strong><br/>
                        Configure your feedback submission form to encourage your users to leave feedback about company/service/product
                        <input type="text" value="<?=$hosted_full_page->submit_form_text?> " name="submit_form_text" id="header-title-text" class="wizard-text-field" title="Header Title" />
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
                <div class="grids" style="height:314px">
                    <img src="/img/hosted-form-preview.jpg" />
                </div>
                <div class="grids">
                    <div class="g3of4">
                        <strong>Customize your submission form feedback prompt</strong><br />
                        Configure your feedback prompt to encourage users to say something specific about your brand, product or service.
                        <textarea id="form-what-to-write" name="submit_form_question" class="wizard-text-field" rows="6" title="What do you like about our products?">
<?=trim($hosted_full_page->submit_form_question)?> 
                        </textarea>
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
            </div>                     
        </div>
        -->
        <input type="submit" class="large-btn create-widget-button" value="save widget" / >
    </div>
    <div class="block noborder" style="height:50px;">        
    </div>
</div>

<div class="c"></div>
<?=Form::close()?>
