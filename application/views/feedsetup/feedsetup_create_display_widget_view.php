<?=Form::open('feedsetup/save_display_widget', 'POST', Array('id' => 'create-widget'))?>
<?$site_id = Input::get('site_id')?>
<?=Form::hidden('widget_type', 'display')?>
<?=Form::hidden('site_id', $site_id)?>
<?=Form::hidden('company_id', $company_id)?>
<?=Form::hidden('display_widgetkey', false)?>
<?=Form::hidden('submit_widgetkey', false)?>
<?=Form::hidden('theme_type', 'form-aglow', Array('id' => 'selected-form'))?>
<span id="preview-form-widget-url" hrefaction="<?=URL::to('feedsetup/preview_widget_style')?>"></span>
<div class="block">
    <div>
        <div class="widget-options" style="position:relative;">
            <div class="the-selected-widget-box">
                <?if($widget_select == 'embed'):?>
                    <strong>Embedded display selected </strong> 
                <?endif;?>

                <?if($widget_select == 'modal'):?>
                    <strong>Modal Popup display selected </strong> 
                <?endif;?>
                (<small style="text-decoration:underline;"><?=HTML::link('feedsetup/widget_selection', 'change')?></small>)
                <br /><br />
                <div class="the-selected-widget-img">
                    <?if($widget_select == 'embed'):?> 
                        <?=HTML::image('img/embed-widget-preview.jpg')?>
                    <?endif;?>

                    <?if($widget_select == 'modal'):?> 
                        <?=HTML::image('img/popup-widget-preview.jpg')?>
                    <?endif;?>                    
                </div>
            </div>        

            <br />
            <div class="widget-types">
                <strong style="padding-left:3px;color:#000;">

                    CUSTOMIZE YOUR
                    <?if($widget_select == 'embed'):?> 
                        EMBEDDED
                    <?endif;?>

                    <?if($widget_select == 'modal'):?> 
                         POPUP
                    <?endif;?>
                    DISPLAYS 

                </strong>
                <br /><br />
                <table>
                    <tr><td width="110"><strong style="font-size:11px;">Name and save as..</strong></td>
                        <td width="200">
                            <input type="text" class="regular-text" name="theme_name" value="" title="Name of your widget" />
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
                         <input type="text" class="regular-text" name="form_text" style="padding:8px;"  title="What our customers have to say" />
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
                        <tr>
                            <td width="160" class="feedback-td-font">Display Name :</td>
                            <td width="80">
                                <?=Form::checkbox('perms[feedbacksetupdisplay][displayname]', 1, 1, array('disabled' => 'disabled'))?>
                            </td>
                            <?=Form::hidden('perms[feedbacksetupdisplay][displayname]', 1)?>
                            <td width="160" class="feedback-td-font">Website Url : </td>
                            <td width="80">
                                <?=Form::checkbox('perms[feedbacksetupdisplay][displayurl]', 1, 1)?>
                            </td>
                        </tr>
                        <tr><td class="feedback-td-font">Display Image :  </td><td>
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displayimg]', 1, 1)?>
                        </td>		
                        <td class="feedback-td-font">Country & Flag : </td><td>
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaycountry]', 1, 1)?>
                        </td></tr>
                        <tr><td class="feedback-td-font">Company Name :</td><td>
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaycompany]', 1, 1)?>
                        </td>			
                        <td class="feedback-td-font">Submitted Date : </td><td>
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaysbmtdate]', 1, 1)?>
                        </td></tr>
                        <tr><td class="feedback-td-font">Designation / Position :</td><td>
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displayposition]', 1, 1)?>
                        </td><td></td><td></td></tr>
                    </table>
                    <div id="widget_options" class="error-msg"></div>
                </div>
            </div>

            <br/> 
            <div class="widget-types">
                <?if($widget_select == 'embed'):?>
                    <strong style="padding-left:3px;color:#000;">
                        <input type="radio" name="embed_type" id="embed_type" value="embedded" checked style="display:none"/> <label for="embed_type">Embedded Block</label>
                    </strong>
                    <div class="widget-opts" id="embed_widget">
                        <table width="100%">
                            <tr><td width="170" class="feedback-td-font">Choose Block Type</td>
                                <td>
                                    <input type="radio" name="embed_block_type" value="embed_block_x" id="horizontal_embed" /> <label for="horizontal_embed" class="feedback-td-font">Horizontal</label>
                                </td>
                                <td>
                                    <input type="radio" name="embed_block_type" value="embed_block_y" id="vertical_embed" /> <label for="vertical_embed" class="feedback-td-font">Vertical</label>
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
                                        <?foreach($effects_options as $rows):?>        
                                            <option value="<?=$rows->effectsid?>"><?=$rows->effectsname?></option>
                                        <?endforeach?> 
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?endif?>

                <?if($widget_select == 'modal'):?>
                    <strong style="padding-left:3px;color:#000">
                        <input type="radio" name="embed_type" id="modal_type" value="modal" checked style="display:none"/> <label for="modal_type">Modal / Popup</label>
                    </strong>
                    <div class="widget-opts" id="modal_widget">
                        <table width="100%">
                            <tr><td width="170" class="feedback-td-font">Transition :</td>
                                <td>
                                    <select name="modal_effects" class="regular-select">       
                                        <?foreach($effects_options as $rows):?>        
                                            <option value="<?=$rows->effectsid?>"><?=$rows->effectsname?></option>
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

                <?endif?>
            </div>

            <br/>
            <div class="widget-types">
                <strong style="padding-left:3px;color:#000;">Select your display theme</strong>
                    <div class="widget-opts" style="margin-left: -18px">
                        <div class="form-design-slide">
                            <div class="form-design-prev">
                            </div>
                                <div class="form-designs grids">  
                                <?php
                                    $form_slides = '';
                                    $units = 7;
                                    $ctr = 0;
                                    $max = count($form_themes);
                                    
                                    foreach($form_themes as $form_colors => $val){
                                        if (($ctr % $units) == 0) {
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
                        <td><input type="text" class="form-text regular-text" style="padding:8px;width:200px;" name="submit_form_text" value="" title="Give us your feedback" /></td>
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
                            <textarea name="submit_form_question" class="regular-textarea" style="width:230px;font-family:Arial, Helvetica, sans-serif;padding:5px 8px;" rows="8" 
                            title="What do you like about our products?">
                            </textarea>
                        </td>
                    </tr> </tbody>
                </table> 
            </div>
            <!--
            <br/>
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
                                   <option value="<?=$sites->siteid?>" <?=(Input::get('site_id') == $sites->siteid) ? 'selected' : null?>><?=$sites->domain?></option>
                               <?endforeach?>
                           </select>
                        </td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
            -->
            
            <br/>
            <div class="widget-types">
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
                    <div class="widget-block" style="position:relative">
                        <h2>IFrame Widget Code</h2>
                        <div class="html-code">
                            <textarea id="iframe-generate-view" spellcheck="false"></textarea>
                            <!-- add this -->
                            <div class="copycheck"><img src="/img/ico-green-check.png" style="margin:0;padding:0;" /> Copied!</div> 
                            <!-- end add this -->
                        </div>
                    </div>
                    <a href="javascript;;" class="button-gray" id="copy-widget-js">Copy JS Code</a>
                    <a href="javascript;;" class="button-gray" id="copy-widget-iframe">Copy IFrame Code</a>
                    <span id="preview-widget" hrefaction="<?=URL::to('/feedsetup/generate_code')?>"></span>
                </div>     
            </div>

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
