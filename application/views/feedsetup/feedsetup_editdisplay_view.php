<?=Form::open('feedsetup/save_display_widget', 'POST', Array('id' => 'create-widget'))?>
<?=Form::hidden('widget_type', 'display')?>
<?=Form::hidden('company_id', $company_id)?>
<?=Form::hidden('site_id', $widget->site_id)?>
<?=Form::hidden('display_widgetkey', $widget->widgetkey)?>
<?=Form::hidden('submit_widgetkey', $widget->children[0]->widgetkey)?>
<?=Form::hidden('widget_select', (($widget->embed_type == 'embedded') ? 'embed' : 'modal'))?>

<?=Form::hidden('theme_type', 'form-'.$widget->theme_type, Array('id' => 'selected-form'))?>
<span id="preview-form-widget-url" hrefaction="<?=URL::to('feedsetup/preview_widget_style')?>"></span>
<span id="formcode-manager-url" hrefaction="<?=URL::to('feedsetup/formcode_manager')?>"></span>

<div class="block">
    <div>
        <div class="widget-options" style="position:relative;">
            <div class="the-selected-widget-box">
                <?if($widget->embed_type == 'embedded'):?>
                    <strong>Embedded display</strong> 
                <?endif;?>

                <?if($widget->embed_type == 'modal'):?>
                    <strong>Modal Popup display</strong> 
                <?endif;?>
                <!--(<small style="text-decoration:underline;"><?=HTML::link('feedsetup/widget_selection', 'change')?></small>)-->
                <br /><br />
                <div class="the-selected-widget-img">
                    <?if($widget->embed_type == 'embedded'):?> 
                        <?=HTML::image('img/embed-widget-preview.jpg')?>
                    <?endif;?>

                    <?if($widget->embed_type == 'modal'):?> 
                        <?=HTML::image('img/popup-widget-preview.jpg')?>
                    <?endif;?>
                    
                </div>
            </div>        

            <br />
            <div class="widget-types">
                <strong style="padding-left:3px;color:#000;">CUSTOMIZE YOUR POPUP DISPLAYS</strong>
                <br /><br />
                <table>
                    <tr><td width="110"><strong style="font-size:11px;">Name and save as..</strong></td>
                        <td width="200">
                            <input type="text" class="regular-text" value="<?=$widget->theme_name?>" title="<?=$widget->theme_name?>" name="theme_name"/>
                        </td>
                    </tr>
                </table>
            </div>

            <br />
            <div class="widget-types">
                <strong style="color:#447697;padding-left:3px;">Feedback Display Options</strong>
                <br /><br />
                <table>
                    <tr><td width="110"><strong style="font-size:11px;">Your header text</strong></td>
                        <td width="200">
                         <input type="text" class="regular-text" name="form_text" style="padding:8px;" value="<?=$widget->form_text?>" title="<?=$widget->form_text?>" />
                        </td>
                    </tr>
                </table>
            </div>

            <br />
            <div class="widget-types">
                <strong style="padding-left:3px;color:#000;">Feedback detail display options</strong>
                <br /><br />
                <div class="widget-opts" id="display-info-target">
                    <table width="100%" cellpadding="4" class="display-info">
                        <tr><td width="160" class="feedback-td-font">Display Name :</td><td width="80">
                            <?=Form::checkbox( 'perms[feedbacksetupdisplay][displayname]'
                                              , 1
                                              , (($widget->perms['displayname']) ? 1 : null) 
                                              , array('disabled' => 'disabled'))?>
                            <?=Form::hidden('perms[feedbacksetupdisplay][displayname]', 1)?>
                            </td>
                            <td width="140" class="feedback-td-font">Website Url : </td><td>
                            <?=Form::checkbox('perms[feedbacksetupdisplay][displayurl]', 1, (($widget->perms['displayurl']) ? 1 : null) )?>
                            </td></tr>
                            <tr><td class="feedback-td-font">Display Image :  </td><td>
                            <?=Form::checkbox('perms[feedbacksetupdisplay][displayimg]'
                                              , 1
                                              , (($widget->perms['displayimg']) ? 1 : null) 
                                              , array('disabled' => 'disabled'))?>
                            <?=Form::hidden('perms[feedbacksetupdisplay][displayimg]', 1)?>
                            </td>		
                            <td class="feedback-td-font">Country & Flag : </td><td>
                            <?=Form::checkbox('perms[feedbacksetupdisplay][displaycountry]', 1, (($widget->perms['displaycountry']) ? 1 : null) )?>
                            </td></tr>
                            <tr><td class="feedback-td-font">Company Name :</td><td>
                            <?=Form::checkbox('perms[feedbacksetupdisplay][displaycompany]', 1, (($widget->perms['displaycompany']) ? 1 : null) )?>
                            </td>			
                            <td class="feedback-td-font">Submitted Date : </td><td>
                            <?=Form::checkbox('perms[feedbacksetupdisplay][displaysbmtdate]', 1, (($widget->perms['displaysbmtdate']) ? 1 : null) )?>
                            </td></tr>
                            <tr><td class="feedback-td-font">Designation / Position :</td><td>
                            <?=Form::checkbox('perms[feedbacksetupdisplay][displayposition]', 1, (($widget->perms['displayposition']) ? 1 : null) )?>
                        </td><td></td><td></td></tr>
                    </table>
                    <div id="widget_options" class="error-msg"></div>
                </div>
            </div>

            <br/> 
            <div class="widget-types">

                <p style="padding-left:3px;color:#000;">
                    <input type="radio" name="embed_type" id="embed_type" value="embedded" 
                     <?=($widget->embed_type == 'embedded') ? "checked" : null?>
                    /> <label for="embed_type">Embedded Block</label>
                </p>
                <div class="widget-opts" id="embed_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Choose Block Type</td>
                            <td>
                                <input type="radio" name="embed_block_type" value="embed_block_x" id="horizontal_embed"  
                                    <?=($widget->embed_type == 'embedded' && $widget->embed_block_type == 'embed_block_x') ? 'checked' : null?>
                                /> 
                                <label for="horizontal_embed" class="feedback-td-font">Horizontal</label>
                            </td>
                            <td>
                                <input type="radio" name="embed_block_type" value="embed_block_y" id="vertical_embed"  
                                    <?=($widget->embed_type == 'embedded' && $widget->embed_block_type == 'embed_block_y') ? 'checked' : null?>
                                /> 
                                <label for="vertical_embed" class="feedback-td-font">Vertical</label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <?=HTML::image('img/preview-horizontal-embed.png')?>
                            </td>
                            <td>
                                <?=HTML::image('img/preview-vertical-embed.png')?>
                            </td>
                        </tr>
                        <tr>
                            <td class="feedback-td-font">Transition Effect : </td>
                            <td colspan="2">
                                <select name="embed_effects" class="regular-select">  
                                    <?foreach ($effects_options as $rows):?>        
                                        <option value="<?=$rows->effectsid?>" 
                                        <?=($widget->embed_type == 'embedded' && $widget->embed_effects == $rows->effectsid) ? 'selected' : null?>
                                        ><?=$rows->effectsname?></option>
                                    <?endforeach?> 
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <p style="padding-left:3px;color:#000">
                    <input type="radio" name="embed_type" id="modal_type" value="modal" 
                     <?=($widget->embed_type == 'modal') ? "checked" : null?>
                    /> <label for="modal_type">Modal / Popup</label>
                </p>
                <div class="widget-opts" id="modal_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Transition :</td>
                            <td> 
                                <select name="modal_effects" class="regular-select">       
                                    <?foreach($effects_options as $rows):?>        
                                        <option value="<?=$rows->effectsid?>" 
                                        <?=($widget->embed_type == 'modal' && $widget->modal_effects == $rows->effectsid) ? 'selected' : null?>
                                        ><?=$rows->effectsname?></option>
                                    <?endforeach?> 
                                </select>
                            </td>
                        </tr>
                        <!--
                        <tr>
                            <td></td>
                            <td>
                                <?=HTML::image('img/preview-modal.png')?>
                            </td>
                        </tr>
                        -->
                    </table>
                </div>
            </div>

            <br/>
            <div class="widget-types">
                <strong style="padding-left:3px;color:#000;">Select your display theme</strong>
                <br/>
                    <select class="regular-select" id="theme-select">
                        <?foreach($main_themes as $main_theme):?>
                            <option value="<?=$main_theme?>" <?=($themes_parent == $main_theme) ? 'selected' : null?>><?=ucwords($main_theme)?></option>
                        <?endforeach?>
                    </select>
                    <div class="widget-opts" style="margin-left: -18px">
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
                    <div class="c"></div>
                </div>
            </div>

            <br />
            <div class="widget-types">
                <strong style="padding-left:3px;color:#447697;">Feedback Form Options</strong>
                <br />
                <p style="font-size:11px;padding-left:3px;">Users will be able to submit feedback through your feedback display through a popup form</p>
                <table width="100%" cellpadding="5" cellspacing="0">
                    <tbody><tr>
                        <td width="140">
                            <strong style="font-size:11px;color:#000;">Form Header Text :</strong>
                        </td>
                        <td><input type="text" id="form-header-text" class="form-text regular-text" style="padding:8px;width:200px;" name="submit_form_text" value="<?=$widget->children[0]->submit_form_text?>" title="<?=$widget->children[0]->submit_form_text?>"  /></td>
                        <td rowspan="2"valign="top">
                            <br /><br /><br />
                            <p style="font-size:11px;">See how your form will <br /> appear to your visitors.</p>
                            <br />
                            <a href="#" class="preview-form-widget-button button-gray">Preview</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            What to write?
                            <br />
                            <small style="line-height:normal">
                            Questions to help your customers/visitors respond to your form in a certain way. This text will appear if they click "What to write?". 
                            </small>
                            <br/>
                            <br/>
                        </td>
                        <td valign="top">
                            <textarea name="submit_form_question" id="form-what-to-write" class="regular-textarea" style="width:230px;font-family:Arial, Helvetica, sans-serif;padding:5px 8px;" rows="8" 
                            title="<?=$widget->children[0]->submit_form_question?>">

<?=$widget->children[0]->submit_form_question?>
                            </textarea>
                        </td>
                    </tr> </tbody>
                </table> 
            </div>
            <br/>
            <!--
            <div class="widget-types">
                <strong style="padding-left:3px;color:#447697;">Select your site to apply this widget to..</strong>
                <br /><br /> 
                <table  cellpadding="5" cellspacing="0">
                    <tbody>
                    <tr>
                        <td width="110">
                            <strong style="font-size:11px;color:#000;">Website:</strong>
                            <br />
                            <small style="line-height:normal">Choose which website to apply your widget. </small>
                        </td>
                        <td> 
                           <select name="site_id" id="feedsetup-site-select" class="regular-select" hrefaction="<?=URL::to('feedsetup/render_display_info')?>" style="font-size:15px"> 
                                <?foreach($site as $sites):?>
                                    <option value="<?=$sites->siteid?>" <?=($widget->site_id == $sites->siteid) ? 'selected' : null?>>
                                        <?=$sites->domain?>
                                    </option>
                                <?endforeach?>
                           </select>
                        </td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
            <br/>
            -->
            <br/>
            <div class="widget-types">
                <input type="submit" class="large-btn create-widget-button" value="Save Widget" />
                <!--<input type="submit" class="large-btn preview-display-widget-button" value="Preview Widget" />-->
            </div>
        </div>
    </div>
</div>
<?=Form::close()?>
<div class="c"></div>
