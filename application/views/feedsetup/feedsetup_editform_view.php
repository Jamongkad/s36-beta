<?=Form::open('feedsetup/save_form_widget', 'POST', array('id' => 'create-form-widget'))?>
<?$site_id = Input::get('site_id')?>
<?=Form::hidden('widget_type', 'submit')?>
<?=Form::hidden('company_id', $widget->company_id)?>
<?=Form::hidden('site_id', $widget->site_id)?>
<?=Form::hidden('submit_widgetkey', $widget->widgetkey)?>
<?=Form::hidden('theme_type', $widget->theme_type, Array('id' => 'selected-form'))?>
<?=Form::hidden('tab_type', $widget->tab_type, Array('id' => 'selected-tab'))?>
<?=Form::hidden('embed_type', 'form')?>

<span id="preview-form-widget-url" hrefaction="<?=URL::to('feedsetup/preview_widget_style')?>"></span>
<span id="formcode-manager-url" hrefaction="<?=URL::to('feedsetup/formcode_manager')?>"></span>
<span id="preview-widget" hrefaction="<?=URL::to('/feedsetup/generate_code')?>"></span>

<div class="block">
    <div id="widget-setup-block">
        <div class="widget-options">
            <h2><span>Step 1 :</span> Choose a name for your form and a question to encourage your users</h2>
            <div class="widget-types">
                <table width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                        <td width="120">
                            <strong style="font-size:14px;">Form Name :</strong>
                        </td>
                        <td><input type="text" class="large-text" name="theme_name" value="<?=$widget->theme_name?>" title="<?=$widget->theme_name?>" /></td>
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
                    <td><input type="text" class="large-text" name="submit_form_text" value="<?=$widget->submit_form_text?>" title="<?=$widget->submit_form_text?>" /></td>
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
                    </td>
                    <td valign="top">
                        <textarea name="submit_form_question" class="large-textarea" 
                                  style="margin:0px;width:258px;font-family:Arial, Helvetica, sans-serif;padding:5px 8px;" rows="8" title="<?=$widget->submit_form_question?>">
<?=$widget->submit_form_question?>
                        </textarea>
                    </td>
                </tr>
                <!--
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
                                    <option value="<?=$sites->siteid?>" <?=($widget->site_id== $sites->siteid) ? 'selected' : null?>><?=$sites->domain?></option>
                                <?endforeach?>
                            </select>
                            <div id="site_id" class="error-msg"></div>
                        </div>
                    </td>
                </tr>
                -->                
            </tbody></table>
            </div>

        </div>
        <div class="widget-options">
            <h2><span>Step 3 :</span> Update custom fields for your form (optional)</h2>
            Pwet
            <?print_r($form_render)?>
        </div>
        <!--
        <div class="widget-options"> 
            <h2><span>Step 3 :</span> Select a theme for both your feedback form and floating tab</h2>
            <div class="widget-types">
                <strong style="font-size:14px;">Form Theme Design :</strong>
                <div class="widget-info">
                    <select class="regular-select" id="theme-select" style="margin:0px 38px;">
                        <?foreach($main_themes as $main_theme):?>
                            <option value="<?=$main_theme?>" <?=($themes_parent == $main_theme) ? 'selected' : null?>><?=ucwords($main_theme)?></option>
                        <?endforeach?>
                    </select>
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
        </div> 
        -->
        <div class="widget-options">
            <div class="block noborder" style="margin-left:-10px;">
                <input type="submit" class="large-btn create-widget-button" value="Update" />
            </div>
        </div>
    </div>
</div>
<?=Form::close()?>
</div>
<div class="c"></div>
</div>
