<?=Form::open('feedsetup/update_widget', 'POST', Array('id' => 'create-widget'))?>
<?=Form::hidden('company_id', $company_id)?>
<?=Form::hidden('widgetkey', $widget->widgetkey)?>
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
                            <td><input type="text" class="large-text" name="theme_name" value="<?=$widget->widgetobj->theme_name?>" title="Name of your widget" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong style="font-size:14px;">Flavor Text :</strong>
                            </td>
                            <td><input type="text" class="large-text" name="form_text" value="<?=$widget->widgetobj->form_text?>" title="ex. What our customers have to say" /></td>
                        </tr>
                    </table>
            </div>
        </div>

        <div class="widget-options">
            <h2>Website applied to this Widget</h2>
            <div style="padding:10px">
                <select name="site_id" id="feedsetup-site-select" class="regular-select" hrefaction="<?=URL::to('feedsetup/render_display_info')?>" style="font-size:15px"> 
                    <?foreach($site as $sites):?>
                        <option value="<?=$sites->siteid?>" <?=($widget->widgetobj->site_id == $sites->siteid) ? 'selected' : null?>>
                            <?=$sites->domain?>
                        </option>
                    <?endforeach?>
                </select>
                <div id="site_id" class="error-msg"></div>
            </div>
        </div>



        <div class="widget-options">
            <h2>Your chosen Widget type</h2>
            <div class="widget-types">
                <h3>
                    <input type="radio" name="embed_type" id="embed_type" value="embedded" 
                        <?=($widget->widgetobj->embed_type == 'embedded') ? 'checked' : null?>
                    /> 
                    <label for="embed_type">Embedded Block</label>
                </h3>
                <div class="widget-opts" id="embed_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Choose Block Type</td>
                            <td>
                                <input type="radio" name="embed_block_type" value="embed_block_x" id="horizontal_embed"  
                                    <?=($widget->widgetobj->embed_type == 'embedded' && $widget->widgetobj->embed_block_type == 'embed_block_x') ? 'checked' : null?>
                                /> 
                                <label for="horizontal_embed" class="feedback-td-font">Horizontal</label>
                            </td>
                            <td>
                                <input type="radio" name="embed_block_type" value="embed_block_y" id="vertical_embed"  
                                    <?=($widget->widgetobj->embed_type == 'embedded' && $widget->widgetobj->embed_block_type == 'embed_block_y') ? 'checked' : null?>
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
                                  
                                    <option value="0">-</option>
                                    <?foreach ($effects_options as $rows):?>        
                                        <option value="<?=$rows->effectsid?>"
                                        
                                        <?=($widget->widgetobj->embed_type == 'embedded' && $widget->widgetobj->embed_effects == $rows->effectsid) ? 'selected' : null?>
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
                        <?=($widget->widgetobj->embed_type == 'modal') ? 'checked' : null?>
                    /> 
                    <label for="modal_type">Modal / Popup</label>
                </h3>

                <div class="widget-opts" id="modal_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Transition :</td>
                            <td>
                                <select name="modal_effects" class="regular-select">       
                                    <option value="0">-</option>
                                    <?foreach($effects_options as $rows):?>        
                                        <option value="<?=$rows->effectsid?>"
                                        
                                        <?=($widget->widgetobj->embed_type == 'modal' && $widget->widgetobj->modal_effects == $rows->effectsid) ? 'selected' : null?>
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
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayname]', 1, (($widget->widgetobj->perms['displayname']) ? 1 : null) )?>
                    </td>
                    <td width="140" class="feedback-td-font">Website Url : </td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayurl]', 1, (($widget->widgetobj->perms['displayurl']) ? 1 : null) )?>
                    </td></tr>
                    <tr><td class="feedback-td-font">Display Image :  </td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayimg]', 1, (($widget->widgetobj->perms['displayimg']) ? 1 : null) )?>
                    </td>		
                    <td class="feedback-td-font">Country & Flag : </td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displaycountry]', 1, (($widget->widgetobj->perms['displaycountry']) ? 1 : null) )?>
                    </td></tr>
                    <tr><td class="feedback-td-font">Company Name :</td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displaycompany]', 1, (($widget->widgetobj->perms['displaycompany']) ? 1 : null) )?>
                    </td>			
                    <td class="feedback-td-font">Submitted Date : </td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displaysbmtdate]', 1, (($widget->widgetobj->perms['displaysbmtdate']) ? 1 : null) )?>
                    </td></tr>
                    <tr><td class="feedback-td-font">Designation / Position :</td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayposition]', 1, (($widget->widgetobj->perms['displayposition']) ? 1 : null) )?>
                    </td><td></td><td></td></tr>
                </table>
                <div id="widget_options" class="error-msg"></div>
            </div>
        </div>
        <div class="widget-options">
            <h2>Theme</h2>
            <div class="widget-opts">
                <div class="templates" id="template-slider">
                    <!--
                    <ul>
                       <?foreach($themes as $theme):?>
                           <li>
                                <div id="themeId_<?=$theme->themeid?>"><?=Form::radio('theme_id', $theme->themeid)?> <?=$theme->name?></div>
                                <div><?=HTML::image('img/display-thumb.png')?></div> 
                           </li> 
                       <?endforeach?>
                       <li class="c"></li>
                    </ul>
                    -->
                    <ul>
                        <li>
                            <div id="themeId_1"><?=Form::radio('theme_type', 'aglow')?> Aglow</div>
                            <div><?=HTML::image('img/display-thumb.png')?></div> 
                        </li>
                    </ul>
                </div>
                <!--
                <div class="slider-navigation">
                    <div class="prev-next-button">
                        <div class="next-button" id="next"></div>
                        <div class="prev-button" id="prev"></div>
                    </div>
                    <div class="counter"><a href="#" class="button">Show All</a></div>
                    <div class="c"></div>
                </div>
                -->
                <div class="c"></div>
            </div>
        </div>
        <div class="widget-options">
            <h2>Code</h2>
            <br/>
            <div class="widget-opts">
                <div style="width: 360px;margin-left:auto;margin-right:auto">
                    <div class="widget-block">
                        <h2>JS Widget Code (recommended)</h2>
                        <div class="html-code">
                            <textarea id="widget-generate-view" spellcheck="false">
                                <?=$js_code?> 
                            </textarea>
                        </div>
                    </div>

                    <div class="widget-block">
                        <h2>IFrame Widget Code</h2>
                        <div class="html-code">
                            <textarea id="iframe-generate-view" spellcheck="false">
                                <?=$iframe_code?> 
                            </textarea>
                        </div>
                    </div>
                </div>    
                <!--
                <div class="block noborder" style="height:490px;"></div>
                -->
                <div class="c"></div>
            </div>
        </div>
        <div class="widget-setup-border"></div>
        <div class="widget-opts">
            <br />
            <input type="submit" class="large-btn" value="Update Widget" />
            <br /><br />
        </div>
    </div>
</div>
<?=Form::close()?>
</div>
<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
