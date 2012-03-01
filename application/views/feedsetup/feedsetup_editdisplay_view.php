<?=Form::open('feedsetup/save_widget', 'POST', Array('id' => 'create-widget'))?>
<?=Form::hidden('widget_type', 'display')?>
<?=Form::hidden('company_id', $company_id)?>
<?=Form::hidden('display_widgetkey', $widget->widgetkey)?>
<?=Form::hidden('submit_widgetkey', $widget->children[0]->widgetkey)?>
<?=Form::hidden('theme_type', 'form-'.$widget->theme_type, Array('id' => 'selected-form'))?>
<span id="preview-form-widget-url" hrefaction="<?=URL::to('feedsetup/preview_widget_style')?>"></span>
<div class="block">
    <div id="widget-setup-block"> 
        <div class="widget-options">
            <h2>Your Widget name</h2>
            <div class="widget-types">
                    <table width="100%" cellpadding="5" cellspacing="0">
                        <tr>
                            <td width="120">
                                <strong style="font-size:14px;">Widget Name :</strong>
                            </td>
                            <td><input type="text" class="large-text" name="theme_name" value="<?=$widget->theme_name?>" title="Name of your widget" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong style="font-size:14px;">Flavor Text :</strong>
                            </td>
                            <td><input type="text" class="large-text" name="form_text" value="<?=$widget->form_text?>" title="What our customers have to say" /></td>
                        </tr>
                    </table>
            </div>
        </div>

        <div class="widget-options">
            <h2><span>Step 2 :</span> Optional - Customize your form if you wish </h2>
            <div class="widget-types">
            <table width="100%" cellpadding="5" cellspacing="0">
                <tbody><tr>
                    <td width="140">
                        <strong style="font-size:14px;">Form Header Text :</strong>
                    </td>
                    <td><input type="text" class="form-text" name="submit_form_text" value="" title="<?=$widget->children[0]->submit_form_text?>" /></td>
                    <td rowspan="2" width="150" align="center" valign="top">
                        <br /><br />
                        <big>See how your form will <br /> appear to your visitors.</big>
                        <br /><br />
                        <a href="#" class="preview-form-widget-button button-gray">Preview</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong style="font-size:14px;">What to write?</strong>
                        <br />
                        <small style="line-height:normal">
                        Questions to help your customers/visitors respond to your form in a certain way. This text will appear if they click "What to write?". 
                        <br/>
                        <br/>
                    </td>
                    <td valign="top">
                        <textarea name="submit_form_question" class="large-textarea" style="margin:0px;width:258px;font-family:Arial, Helvetica, sans-serif;padding:5px 8px;" rows="8" 
                        title="<?=$widget->children[0]->submit_form_question?>">
                        
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
                                    <option value="<?=$sites->siteid?>" <?=($widget->site_id == $sites->siteid) ? 'selected' : null?>>
                                        <?=$sites->domain?>
                                    </option>
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
            <h2>Your chosen Widget type</h2>
            <div class="widget-types">
                <h3>
                    <input type="radio" name="embed_type" id="embed_type" value="embedded" 
                        <?=($widget->embed_type == 'embedded') ? 'checked' : null?>
                    /> 
                    <label for="embed_type">Embedded Block</label>
                </h3>
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
            </div>
            <div class="widget-types">
                <h3>
                    <input type="radio" name="embed_type" id="modal_type" value="modal" 
                        <?=($widget->embed_type == 'modal') ? 'checked' : null?>
                    /> 
                    <label for="modal_type">Modal / Popup</label>
                </h3>

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
                        <tr><td></td>
                            <td>
                                <?=HTML::image('img/preview-modal.png')?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="embed_type" class="error-msg"></div>
        </div>
        <div class="widget-options">
            <h2>Widget Display Options</h2>
            <div class="widget-opts" id="display-info-target">
                <table width="100%" cellpadding="4" class="display-info"> 
                    <tr><td width="160" class="feedback-td-font">Display Name :</td><td width="80">
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayname]', 1, (($widget->perms['displayname']) ? 1 : null) )?>
                    </td>
                    <td width="140" class="feedback-td-font">Website Url : </td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayurl]', 1, (($widget->perms['displayurl']) ? 1 : null) )?>
                    </td></tr>
                    <tr><td class="feedback-td-font">Display Image :  </td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayimg]', 1, (($widget->perms['displayimg']) ? 1 : null) )?>
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
        <div class="widget-options">
            <h2>Widget Theme</h2>
            <div class="widget-opts" style="margin:0px -10px;">

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
                                                        <img src="/img/display-thumb.png "/>
                                                        <span>'.$val.'</span>
                                                        <!--
                                                        <div id="preview" class="preview button-gray">
                                                            Preview
                                                        </div>
                                                        -->
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
           
                <div class="c"></div>
            </div>
        </div>
        <div class="widget-options">
            <h2>Code</h2>
            <br/>
            <div class="widget-opts" style="text-align:center">
                <div style="width: 360px;margin-left:auto;margin-right:auto">
                    <div class="widget-block" style="position:relative">
                        <h2>JS Widget Code (recommended)</h2>
                        <div class="html-code">
                            <textarea id="widget-generate-view" spellcheck="false">
                                <?=$js_code?> 
                            </textarea>
                            <!-- add this -->
                            <div class="copycheck"><img src="/img/ico-green-check.png" style="margin:0;padding:0;" /> Copied!</div> 
                            <!-- end add this -->
                        </div>
                    </div>

                    <div class="widget-block" style="position:relative">
                        <h2>IFrame Widget Code</h2>
                        <div class="html-code">
                            <textarea id="iframe-generate-view" spellcheck="false">
                                <?=$iframe_code?> 
                            </textarea>
                            <!-- add this -->
                            <div class="copycheck"><img src="/img/ico-green-check.png" style="margin:0;padding:0;" /> Copied!</div> 
                            <!-- end add this -->
                        </div>
                    </div>
                    <a href="javascript;;" class="button-gray" id="copy-widget-js">Copy JS Code</a>
                    <a href="javascript;;" class="button-gray" id="copy-widget-iframe">Copy IFrame Code</a>
                    <span id="preview-widget" hrefaction="<?=URL::to('/feedsetup/generate_code')?>"></span>
                </div>    
                <!--
                <div class="block noborder" style="height:490px;"></div>
                -->
                <div class="c"></div>
            </div>
        </div>
        <div class="widget-setup-border"></div>
        <div class="widget-opts">
            <div class="block noborder" style="margin-left:-10px;">
                <input type="submit" class="large-btn" value="Update Widget" />
                <input type="submit" class="large-btn preview-display-widget-button" value="Preview Widget" />
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
