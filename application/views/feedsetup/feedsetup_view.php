<?=Form::open('feedsetup/save_widget', 'POST', Array('id' => 'create-widget'))?>
<?$site_id = Input::get('site_id')?>
<?=Form::hidden('site_id', $site_id)?>
<?=Form::hidden('company_id', $companyId)?>
<?=Form::hidden('base_url', URL::to('/'))?>
<div class="block">
    <div id="widget-setup-block"> 
        <div class="widget-options">
            <h2><span>Step 1 :</span> Please choose a name for your theme</h2>
            <div style="padding:10px">
                <input type="text" name="theme_name" value="" style="font-size:25px; padding:5px; width:600px"/>
                <div id="theme_name" class="error-msg"></div>
            </div>
        </div>
    </div>
    <?if(!$site_id):?>
    <div id="widget-setup-block"> 
        <div class="widget-options">
            <h2><span>Step 2 :</span> Choose your website you want to apply your widget to</h2>
            <div style="padding:10px">
                <select name="site_id" id="feedsetup-site-select" class="regular-select" hrefaction="<?=URL::to('feedsetup/render_display_info')?>" style="font-size:15px"> 
                    <option value="">--</option>
                    <?foreach($site as $sites):?>
                        <option value="<?=$sites->siteid?>" <?=(Input::get('site_id') == $sites->siteid) ? 'selected' : null?>><?=$sites->domain?></option>
                    <?endforeach?>
                </select>
                <div id="site_id" class="error-msg"></div>
            </div>
        </div>
    </div>
    <?endif?>
    <div id="widget-setup-block">
        <div class="widget-options">
            <h2><span>Step <?=(!$site_id) ? 3 : 2?> :</span> Choose Widget</h2>
            <!--
            <div class="widget-types">
                <h3><input type="radio" name="embed_type" id="full_page_type" value="fullpage"/> <label for="full_page_type">Full Page</label></h3>
                <div class="widget-opts" id="full_page_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Units to Display per page:</td>
                            <td>
                                <select name="full_page_units" class="regular-select">
                                    <option value="0">-</option>
                                    <option value="6">6</option>
                                    <option value="12">12</option>
                                    <option value="18">18</option>
                                    <option value="24">24</option>
                                </select>
                            </td>
                        </tr>
                        <tr><td></td>
                            <td>
                                <?=HTML::image('img/preview-fullpage.png')?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            -->
            <div class="widget-types">
                <h3><input type="radio" name="embed_type" id="embed_type" value="embedded"/> <label for="embed_type">Embedded Block</label></h3>
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
                        <!--
                        <tr>
                            <td class="feedback-td-font">Units to Display per page : </td>
                            <td colspan="2">
                                <select name="embed_units" class="regular-select">
                                    <option value="0">-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="feedback-td-font">Display Size : </td>
                            <td colspan="2" class="feedback-td-font">
                                Width (px): <input type="text" class="regular-text small-text" value="0" style="display:inline;" name="embed_width"/>
                                Height (px): <input type="text" class="regular-text small-text" value="0" style="display:inline;" name="embed_height"/>
                            </td>
                        </tr>
                        -->
                        <tr>
                            <td class="feedback-td-font">Transition Effect : </td>
                            <td colspan="2">
                                <select name="embed_effects" class="regular-select"> 
                                  
                                    <option value="0">-</option>
                                    <?foreach($effects_options as $rows):?>        
                                        <option value="<?=$rows->effectsid?>"><?=$rows->effectsname?></option>
                                    <?endforeach?>
                                   
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="widget-types">
                <h3><input type="radio" name="embed_type" id="modal_type" value="modal"/> <label for="modal_type">Modal / Popup</label></h3>
                <div class="widget-opts" id="modal_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Transition :</td>
                            <td>
                                <select name="modal_effects" class="regular-select">       
                                    <option value="0">-</option>
                                    <?foreach($effects_options as $rows):?>        
                                        <option value="<?=$rows->effectsid?>"><?=$rows->effectsname?></option>
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
            <h2><span>Step <?=(!$site_id) ? 4 : 3?> :</span> Display Option</h2>
            <div class="widget-opts" id="display-info-target">
                <table width="100%" cellpadding="4" class="display-info">
                    <tr><td width="160" class="feedback-td-font">Display Name :</td><td width="80">
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayname]', 1, 1)?>
                    </td>
                    <td width="140" class="feedback-td-font">Website Url : </td><td>
                    <?=Form::checkbox('perms[feedbacksetupdisplay][displayurl]', 1, 1)?>
                    </td></tr>
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
        <div class="widget-options">
            <h2><span>Step <?=(!$site_id) ? 5 : 4?> :</span> Select Theme</h2>
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
        <div class="widget-setup-border"></div>

        <div class="widget-opts" style="text-align:center">

            <div id="widget-preview">
                <div class="widget-block">
                    <h2>HTML Code</h2>
                    <div class="html-code">
                        <textarea id="code-generate-view" spellcheck="false"></textarea>
                    </div>
                </div>

                <div class="widget-block">
                    <h2>JS Widget Code (recommended)</h2>
                    <div class="html-code">
                        <textarea id="widget-generate-view" spellcheck="false"></textarea>
                    </div>
                </div>

                <div class="widget-block">
                    <h2>IFrame Widget Code</h2>
                    <div class="html-code">
                        <textarea id="widget-generate-view" spellcheck="false"></textarea>
                    </div>
                </div>
                <!--
                <a href="javascript:;" class="button-gray" id="preview-widget" hrefaction="<?=URL::to('/feedsetup/generate_code')?>">Preview Widget</a>

                <a href="#" class="button-gray" id="generate-feedback-btn" hrefaction="<?=URL::to('/feedsetup/generate_code')?>">Generate Code</a>
                -->
            </div>    
            <div class="block noborder" style="height:660px;"></div>
        </div> 

        <div class="widget-opts">
            <br />
            <!--<a href="#" class="button">Save Widget</a>-->
            <input type="submit" class="large-btn" value="Save Widget & Preview Code" />
            <br /><br />
        </div>
    </div>
</div>
<?=Form::close()?>
<!-- spacer -->
<!-- spacer -->
</div>
<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
