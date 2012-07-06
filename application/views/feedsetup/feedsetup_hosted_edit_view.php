<?=Form::open('feedsetup/update_hosted_settings', 'POST', Array('id' => 'update-hosted'))?>
<?=Form::hidden('companyId', $hosted_full_page->companyid)?>
<?=Form::hidden('theme_type', $hosted_full_page->theme_type, Array('id' => 'selected-form'))?>

<div>
    <div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
        <h3>HOSTED FEEDBACK DISPLAY SETUP</h3>
    </div>
    <div class="block noborder">
        <div id="hosted-wizard">
            <div id="hosted-wizard-step-1" class="wizard-steps current">
                <h2 class="large-black">Step 1 Choose a design theme from the follow categories:</h2>
                <br />                
                <div class="grids">
                    <div class="">
                        <select class="regular-select" id="theme-select">
                            <option value="corporate">Corporate</option>
                            <!--<option value="minimalist">Minimalist</option>-->
                            <option value="creative">Creative</option>
                        </select>
                        <!--<input type="hidden" value="1" id="selected-theme" name="selected-theme" />-->
                        <!--<a href="#">View all Categories</a>-->
                        <div class="grids">
                        <br />
                            <div id="corporate" class="form-design-slide" style="margin-left:-10px;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->corporate->children))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                            <div id="minimalist" class="form-design-slide" style="margin-left:-10px;display:none;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >                                                               
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->minimalist->children))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                            <div id="creative" class="form-design-slide" style="margin-left:-10px;display:none;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >                                                                   
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->creative->children))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div id="hosted-wizard-step-2" class="wizard-steps">
                <h2 class="large-black">Configure your hosted page to suit your website and theme - you can direct visitors to your hosted page to view existing published feedback, or to get them to send in feedback.</h2>
                <br />
                <div class="grids">
                    <div class="g3of4">
                        <span>Configure your feedback header text</span>
                        <input type="text" name="header_text" id="header-text" class="wizard-text-field" 
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
                <h2 class="large-black">Configure your feedback submission form to encourage your users to leave feedback about company/service/product</h2>
                <br />
                <div class="grids">
                    <div class="g3of4">
                        <span>Customize your submission form header title</span>
                        <input type="text" name="submit_form_text" id="header-title-text" class="wizard-text-field" title="Header Title" />
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
                <div class="grids" style="height:314px">
                    <img src="/img/hosted-form-preview.jpg" />
                </div>
                <div class="grids">
                    <h2 class="large-black">Configure your feedback prompt to encourage users to say something specific about your brand, product or service.</h2>
                    <br />
                    <div class="g3of4">
                        <span>Customize your submission form feedback prompt:</span>
                        <textarea id="form-what-to-write" name="submit_form_question" class="wizard-text-field" rows="6" title="What do you like about our products?"></textarea>
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
            </div>                     
        </div>
        <input type="submit" class="large-btn create-widget-button" value="save widget" / >
    </div>
    <div class="block noborder" style="height:70px;">        
    </div>
</div>

<div class="c"></div>
<?=Form::close()?>
