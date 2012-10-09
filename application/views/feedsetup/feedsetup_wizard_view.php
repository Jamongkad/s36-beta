<?=Form::open('feedsetup/save_display_widget', 'POST', Array('id' => 'create-widget'))?>
<?=Form::hidden('widget_type', 'display')?>
<?=Form::hidden('company_id', $company_id)?>
<?=Form::hidden('site_id', $site[0]->siteid)?>
<?=Form::hidden('display_widgetkey', false)?>
<?=Form::hidden('submit_widgetkey', false)?>
<?=Form::hidden('widget_select', $widget_select)?>

<?=Form::hidden('theme_type', 'form-matte', Array('id' => 'selected-form'))?>
<?=Form::hidden('perms[feedbacksetupdisplay][displayname]', 1);?>
<?=Form::hidden('perms[feedbacksetupdisplay][displayimg]', 1);?>
<span id="formcode-manager-url" hrefaction="<?=URL::to('feedsetup/formcode_manager')?>"></span>
<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <h3>CUSTOMIZE YOUR EMBEDDED DISPLAYS</h3>
</div>
<br />
<div class="block noborder">
    <div id="wizard">
        <div id="wizard-step-1" class="wizard-steps current">
            <span><strong>Step 1 </strong><span class="blue">Feedback Display Option</span></span>
            <br /><br />
            <span>Name and save as : </span>
            <div class="grids">
                <div class="g3of4">
                    <input type="text" id="form-name" class="regular-text" name="theme_name" value="" title="Name of your widget" />
                    <div class="grids">
                        <div class="g1of3" style="height:200px">
                            <?if($widget_select == 'embed'):?> 
                                <?=HTML::image('img/embed-widget-preview.jpg')?>
                            <?endif;?>

                            <?if($widget_select == 'modal'):?> 
                                <?=HTML::image('img/popup-widget-preview.jpg')?>
                            <?endif;?>                    
                        </div>
                        <div class="g2of3">
                            <br />
                            <span class="blue"><strong>Selected</strong> : 
                            <?if($widget_select == 'embed'):?>
                                Embedded display selected 
                            <?endif;?>

                            <?if($widget_select == 'modal'):?>
                                Modal Popup display selected
                            <?endif;?>
                            </span>
                            <br />
                            <small class="underline"><?=HTML::link('feedsetup/widget_selection', 'change')?></small>
                        </div>
                    </div>
                </div>
                <div class="g1of4">
                    &nbsp;
                </div>
            </div>
        </div>
        <div id="wizard-step-2" class="wizard-steps">
            <span><strong>Step 2 </strong><span class="blue">Feedback Display Option</span></span>
            <br /><br />
            <span>Your header text : </span>
            <div class="grids">
                <div class="g3of4">
                    <input type="text" id="header-text" class="regular-text" name="form_text" style="padding:8px;"  
                           title="What our customers have to say" />
                </div>
                <div class="g1of4">
                    &nbsp;
                </div>
            </div>
            <div class="grids" style="height:185px">
                <img src="/img/embedded-display-preview.jpg" />
            </div>
        </div>
        <div id="wizard-step-3" class="wizard-steps">
            <span><strong>Step 3 </strong><span class="blue">Customize your feedback display effects and layout</span></span>
            <br /><br />
            <span>Transition Effect : </span>
            <div class="grids">
                <div class="g1of4">
                    <select name="embed_effects" class="wizard-select"> 
                        <?foreach($effects_options as $rows):?>        
                            <option value="<?=$rows->effectsid?>"><?=$rows->effectsname?></option>
                        <?endforeach?> 
                    </select>
                </div>
                <div class="g3of4">
                    &nbsp;
                </div>
            </div>
            <div class="grids">
                <?if($widget_select == "embed"):?>
                    <?=Form::hidden('embed_type', 'embedded')?>
                    <div class="g1of4" style="height:250px">
                        <input type="radio" name="embed_block_type" value="embed_block_x" id="horizontal_embed" /> Horizontal
                        <br />
                        <?=HTML::image('img/preview-horizontal-embed.png')?>
                    </div>
                    <div class="g1of4" style="height:250px">
                        <input type="radio" name="embed_block_type" value="embed_block_y" id="vertical_embed" /> Vertical
                        <br />
                        <?=HTML::image('img/preview-vertical-embed.png')?>
                    </div>
                <?endif?>
                <?if($widget_select == "modal"):?>
                    <?=Form::hidden('embed_type', 'modal')?>
                    <div class="g1of4" style="height:250px"> 
                        <?=HTML::image('img/popup-widget-preview.jpg')?>
                    </div>
                <?endif?>
            </div>
            <br />
            <span>Choose your theme : </span>
            <br />

            <div>
                <h2 class="large-black">Step 1 Choose a design theme from the follow categories:</h2>
                <br />                
                <div class="grids">
                    <div class="">
                        <select class="regular-select" id="theme-select">
                            <?foreach($main_themes as $main_theme):?>
                                <option value="<?=$main_theme?>"><?=ucwords($main_theme)?></option>
                            <?endforeach?>
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
                                           array('themes'=> $themes->corporate->children, 'data_type' => 'form'))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                            <div id="minimalist" class="form-design-slide" style="margin-left:-10px;display:none;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >                                                               
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->minimalist->children, 'data_type' => 'form'))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                            <div id="creative" class="form-design-slide" style="margin-left:-10px;display:none;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >                                                                   
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->creative->children, 'data_type' => 'form'))?>
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
        </div>                    
        <div id="wizard-step-4" class="wizard-steps">
            <span><strong>Step 4 </strong><span class="blue">Feedback detail display options </span></span>
            <br /><br />
            <span>Customize the fields you want to show up in your template. <br />
                  Uncheck items you want to hide (example - Country). </span>
            <div class="grids">
                <div class="g1of2">
                <br />
                    <div class="grids wizard-display-options">
                        <p><label>Company Name :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaycompany]', 1, 1, Array(  'class' => 'display-option'
                                                                                                     , 'id' => 'preview-company'))?>
                        </p>
                        <p><label>Designation / Position :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displayposition]', 1, 1, Array(  'class' => 'display-option'
                                                                                                      , 'id' => 'preview-position'))?>
                        </p>
                        <p><label>Website Url :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displayurl]', 1, 1, Array(  'class' => 'display-option'
                                                                                                 , 'id' => 'preview-website'))?>
                        </p>
                        <p><label>Country & Flag : </label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaycountry]', 1, 1, Array(  'class' => 'display-option'
                                                                                                     , 'id' => 'preview-author-location'))?>
                        </p>
                        <p><label>Submitted Date :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaysbmtdate]', 1, 1, Array(  'class' => 'display-option'
                                                                                                      , 'id' => 'preview-feedback-date'))?>
                        </p>
                    </div>
                </div>
                <div class="g1of2">
                    <div class="align-center widget-preview-text">PREVIEW DISPLAY</div>
                    <div class="wizard-feedback-preview">
                        <div id="wizard-preview-box">
                            <div id="wizard-preview-author-info"> 
                                <div id="wizard-preview-avatar">
                                    <img id="avatar-display" src="/img/sample-avatar-2.jpg" />
                                    <img id="avatar-blank" src="/img/48x48-blank-avatar.jpg" style="display:none;"/>
                                </div>
                                <div id="wizard-preview-author-details">
                                    <div id="wizard-preview-author-name">Nelson Cardella</div>
                                    <div id="wizard-preview-author-position"><span id="wizard-preview-position">Marketing Manager,</span> <span id="wizard-preview-company"><a href="javascript:;" id="wizard-preview-website">Davis LLP</a></span></div>
                                    <div id="wizard-preview-author-location">Manitoba City, Canada <span class="flag flag-cn"></span></div>
                                </div>
                            </div>
                            <div id="wizard-preview-feedback-text">
                                I had great time using your product. It was even better than I expected. Will definitely come back again to try your next few dishes out... seriously fantastic.. (<a href="#" class="read-full">read full feedback</a>)
                            </div>
                            <div id="wizard-preview-feedback-date">
                                13th Sept. 2011
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="wizard-step-5" class="wizard-steps">
            <span><strong>Step 5 </strong><span class="blue">Feedback Form Options </span></span>
            <div class="grids" style="overflow:visible;">
                <div class="g1of2">
                    <br />
            <span>Customize the feedback form that your customers<br />and visitors see when they click 'Send Feedback' from your<br />display widget.</span>
                    <br /><br />
                    Form Header Text :
                    <br />
                    <input type="text" id="form-header-text" class="wizard-text-field" name="submit_form_text" value="" title="Give us your feedback" />
                    <br />
                    What to write?
                    <br />
                    <textarea id="form-what-to-write" name="submit_form_question" class="wizard-text-field" rows="6" title="What do you like about our products?"></textarea>
                    <small>Questions to help your customers/visitors respond to your form in a certain way. This text will appear if they click "What to write?".</small>
                    <br />
                    <br />
                    <br />
                    <br />
                </div>
                <div class="g1of2">
                    <img src="/img/form-preview.jpg" style="margin-top:-20px;margin-left:-20px;"/>
                </div>
            </div>
        </div>
        <!--
        <div id="wizard-step-6" class="wizard-steps">
            <span class="blue">Forwarding to our integration menu now…</span>
        </div>
        -->
    </div>
    <div id="wizard-error-prompt"></div>
    <div class="wizard-buttons">
        <a href="javascript:;" class="wizard-btn" id="wizard-back">Back</a>
        &nbsp;
        <a href="javascript:;" class="wizard-btn" id="wizard-next">Next</a> 
        <input type="submit" class="large-btn create-widget-button" value="Save Widget" style="display:none" />
    </div>
</div>
<div class="block noborder" style="height:150px;">
</div>
<?=Form::close()?>
