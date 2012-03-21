<?=Form::open('feedsetup/save_widget', 'POST', array('id' => 'create-form-widget'))?>
<?$site_id = Input::get('site_id')?>
<?=Form::hidden('widget_type', 'submit')?>
<?=Form::hidden('site_id', $site_id)?>
<?=Form::hidden('company_id', $company_id)?>
<?=Form::hidden('submit_widgetkey', false)?>
<?=Form::hidden('theme_type', 'form-aglow', Array('id' => 'selected-form'))?>
<?=Form::hidden('tab_type', 'tab-l-aglow', Array('id' => 'selected-tab'))?>
<?=Form::hidden('embed_type', 'form')?>
<span id="preview-form-widget-url" hrefaction="<?=URL::to('feedsetup/preview_widget_style')?>"></span>
<div class="block">
    <div id="widget-setup-block">
        <div class="widget-options">
            <h2><span>Step 1 :</span> Create Submission Form</h2>
            <!-- selected form and color -->
            <!-- end -->
            <div class="widget-types">
                    <table width="100%" cellpadding="5" cellspacing="0">
                        <tr>
                            <td width="120">
                                <strong style="font-size:14px;">Form Name :</strong>
                            </td>
                            <td><input type="text" class="large-text" name="theme_name" value="" title="Name your form" /></td>
                        </tr>
                    </table>
            </div>
        </div>
        <div class="widget-options">
            <h2><span>Step 2 :</span> Choose a name for your form and a question to encourage your users</h2>
            <div class="widget-types">
            <table width="100%" cellpadding="5" cellspacing="0">
                <tbody><tr>
                    <td width="140">
                        <strong style="font-size:14px;">Form Header Text :</strong>
                    </td>
                    <td><input type="text" class="form-text" name="submit_form_text" value="" title="Give us your feedback" /></td>
                    <td rowspan="2" width="150" align="center" valign="top">
                        <br /><br />
                        <big>See how your form will <br /> appear to your visitors.</big>
                        <br /><br />
                        <a href="#" class="preview-form-widget-button button-gray">Preview</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        What to write?
                        <br />
                        <small style="line-height:normal">
                        Questions to help your customers/visitors respond to your form in a certain way. This text will appear if they click "What to write?". 
                        <br />
                        <br />
                        <!--
                        <a href="#" style="text-decoration:underline;color:#333">Click here to preview what happens.</a></small>
                        -->
                    </td>
                    <td valign="top">
                        <textarea name="submit_form_question" class="form-text" style="margin:0px;width:258px;font-family:Arial, Helvetica, sans-serif;padding:5px 8px;" rows="8" 
                        title="What do you like about our products?">
                        </textarea>
                    </td>
                </tr>
                <tr> 
                    <td><strong style="font-size:14px;">Website: </strong>
                    
                        <br />
                        <small style="line-height:normal">
                            Choose which website to apply your widget.
                        </small>
                    </td>
                    <td align="top"> 
                        <div style="margin-left:-5px">
                            <select name="site_id" id="feedsetup-site-select" class="regular-select" hrefaction="<?=URL::to('feedsetup/render_display_info')?>" style="font-size:15px"> 
                                <?foreach($site as $sites):?>
                                    <option value="<?=$sites->siteid?>" <?=(Input::get('site_id') == $sites->siteid) ? 'selected' : null?>><?=$sites->domain?></option>
                                <?endforeach?>
                            </select>
                            <div id="site_id" class="error-msg"></div>
                        </div>
                    </td>
                </tr>
                
            </tbody></table>
            </div>
        </div>
        <div class="widget-options"> 
            <h2><span>Step 3 :</span> Select a theme for both your feedback form and floating tab</h2>
            <div class="widget-types">
                <strong style="font-size:14px;">Form Theme Design :</strong>
                <div class="widget-info" style="margin:0px -20px;">

                    <div class="form-design-slide">
                        <div class="form-design-prev">
                        </div>
                        <div class="form-designs grids"> 
                        <?php
                            $form_slides = '';
                            $units = 7;
                            $ctr = 0;
                            $max = count($form_themes);
                            
                            foreach($form_themes  as $form_colors => $val){
                                if(($ctr % $units) == 0){
                                    $form_slides .= '<div class="form-design-group grids">';
                                    $end = 1;
                                }
  
                                    $color_name = 'form-'.$form_colors;
                                    $form_slides .= '<div class="form-design" id="'.$color_name.'">
                                                        <img src="/img/tab-designs/'.$form_colors.'-form.png" height="60" />
                                                        <span>'.$val.'</span>
                                                        <div id="preview" class="preview button-gray">
                                                            Preview
                                                        </div>
                                                    </div>';
                                
                                 if(($end == $units) || $ctr == ($max - 1)){
                                    $form_slides .= '</div>';
                                }
                                $end++;
                                $ctr++;
                            }
                            echo $form_slides
                        ?>
                        </div> 
                        <div class="form-design-next">
                        </div>
                    </div>
                </div>  
            </div>
        </div>

        <div class="widget-opts" style="text-align:center">

            <div id="widget-preview">
                <div class="widget-block" style="position:relative">
                    <h2>JS Widget Code (recommended)</h2>
                    <div class="html-code">
                        <textarea id="widget-generate-view" spellcheck="false"></textarea>
                        <!-- add this -->
                        <div class="copycheck"><img src="/img/ico-green-check.png" style="margin:0;padding:0;" /> Copied!</div> 
                        <!-- end add this -->
                    </div>
                </div>
                <a href="javascript;;" class="button-gray" id="copy-widget-js">Copy JS Code</a>
                <span id="preview-widget" hrefaction="<?=URL::to('/feedsetup/generate_code')?>"></span>  
            </div>    
        </div> 

        <div class="widget-options">
            <div class="block noborder" style="margin-left:-10px;">
                <input type="submit" class="large-btn create-widget-button" value="Save" />
                <input type="submit" class="large-btn preview-form-widget-button" value="Preview Form" />
            </div>
        </div>
    </div>
</div>
<?=Form::close()?>
</div>

<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
