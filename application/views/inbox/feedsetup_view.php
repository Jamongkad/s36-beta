<div class="block">
    <div id="widget-setup-block">
        <div class="widget-options">
            <h2><span>Step 1 :</span> Choose Widget</h2>
            <div class="widget-types">
                <h3><input type="radio" name="embed_type" id="full_page_type" /> <label for="full_page_type">Full Page</label></h3>
                <div class="widget-opts" id="full_page_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Units to Display per page:</td>
                            <td>
                                <select class="regular-select">
                                    <option>6</option>
                                    <option>12</option>
                                    <option>18</option>
                                    <option>24</option>
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
            <div class="widget-types">
                <h3><input type="radio" name="embed_type" id="embed_type" /> <label for="embed_type">Embedded Block</label></h3>
                <div class="widget-opts" id="embed_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Choose Block Type</td>
                            <td>
                                <input type="radio" name="embed_block_type" id="horizontal_embed" /> <label for="horizontal_embed" class="feedback-td-font">Horizontal</label>
                            </td>
                            <td>
                                <input type="radio" name="embed_block_type" id="vertical_embed" /> <label for="vertical_embed" class="feedback-td-font">Vertical</label>
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
                            <td class="feedback-td-font">Units to Display per page : </td>
                            <td colspan="2">
                                <select class="regular-select">
                                    <option>6</option>
                                    <option>12</option>
                                    <option>18</option>
                                    <option>24</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="feedback-td-font">Display Size : </td>
                            <td colspan="2" class="feedback-td-font">
                                Width : <input type="text" class="regular-text small-text" style="display:inline;" />
                                Height : <input type="text" class="regular-text small-text" style="display:inline;" />
                            </td>
                        </tr>
                        <tr>
                            <td class="feedback-td-font">Transition Effect : </td>
                            <td colspan="2">
                                <select class="regular-select">
                                    <option>Fade</option>
                                    <option>Scroll Vertical</option>
                                    <option>Scroll Horizontal</option>
                                    <option>Uncover</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="widget-types">
                <h3><input type="radio" name="embed_type" id="modal_type" /> <label for="modal_type">Modal / Popup</label></h3>
                <div class="widget-opts" id="modal_widget">
                    <table width="100%">
                        <tr><td width="170" class="feedback-td-font">Transition :</td>
                            <td>
                                <select class="regular-select">
                                    <option>Fade</option>
                                    <option>Scroll Vertical</option>
                                    <option>Scroll Horizontal</option>
                                    <option>Uncover</option>
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
        </div>
        <div class="widget-options">
            <h2><span>Step 2 :</span> Display Option</h2>
            <div class="widget-opts">
            <table width="100%" cellpadding="4">
                <tr><td width="160" class="feedback-td-font">Display Name :</td><td width="80"><input type="checkbox" /></td>
                <td width="140" class="feedback-td-font">Website Url : </td><td><input type="checkbox" /></td></tr>
                <tr><td class="feedback-td-font">Display Image :  </td><td><input type="checkbox" /></td>		
                <td class="feedback-td-font">Country & Flag : </td><td><input type="checkbox" /></td></tr>
                <tr><td class="feedback-td-font">Company Name :</td><td><input type="checkbox" /></td>			
                <td class="feedback-td-font">Submitted Date : </td><td><input type="checkbox" /></td></tr>
                <tr><td class="feedback-td-font">Designation / Position :</td><td><input type="checkbox" /></td><td></td><td></td></tr>
            </table>
            </div>
        </div>
        <div class="widget-options">
            <h2><span>Step 3 :</span> Select Theme</h2>
            <div class="widget-opts">
                <div class="templates" id="template-slider">
                    <ul>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li class="c"></li>
                    </ul>
                    <ul>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li>
                            <div><?=HTML::image('img/display-thumb.png')?></div>
                            <div>Sample Name </div>
                        </li>
                        <li class="c"></li>
                    </ul>
                </div>
                <div class="slider-navigation">
                    <div class="prev-next-button">
                        <div class="next-button" id="next"></div>
                        <div class="prev-button" id="prev"></div>
                    </div>
                    <div class="counter"><a href="#" class="button">Show All</a></div>
                    <div class="c"></div>
                </div>
            </div>
        </div>
        <div class="widget-setup-border"></div>
        
        <div class="widget-opts" style="height:240px;">
            <br />
            <a href="#" class="button-gray">Preview Widget</a>
            <br />
            <br />
            <a href="#" class="button-gray">Generate Code</a>
            <br />
            <br />
            
            <div id="widget-preview">
                <div class="widget-block">
                    <h2>HTML Code</h2>
                    <div class="html-code">
                        <textarea spellcheck="false"><iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fplatform&amp;width=292&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=true&amp;header=true&amp;height=590" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:590px;" allowTransparency="true"></iframe></textarea>
                    </div>
                </div>
            </div>
    
        </div>
        <div class="widget-setup-border"></div>
        <div class="widget-opts">
            <br />
            <a href="#" class="button">Save Widget</a>
            <br /><br />
        </div>
    </div>
</div>

<!-- spacer -->
<div class="block noborder" style="height:300px;">
</div>
<!-- spacer -->
</div>

<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>


<!--
<div class="block">
    <p>Customized testimonials will appear on your website. Configure single display units to appear on each prominent location on your website, or configure an entire page to show the latest approved entries.</p>
</div>
<div class="block">
    <h3>POPUP DISPLAY</h3>
    <div class="g1of4">
        <?=HTML::image('img/pop-up-display.png')?>
    </div>
    <div class="g3of4">
        <p>Allows your visitors to view feedback your customers <br /> left through a floating popup on your page. </p>
        <a href="#" class="customize">CUSTOMIZE</a>
    </div>
    <div class="c"></div>
</div>
<div class="block">
    <h3>SINGLE UNIT FEEDBACK</h3>
    <div class="g1of4">
        <?=HTML::image('img/single-display-feedback.png')?>
    </div>
    <div class="g3of4">
        <p>Suitable for selective placement areas within sidebars,<br />footers or even headers of your pages. </p>
        <a href="#" class="customize">CUSTOMIZE</a>
    </div>
    <div class="c"></div>
</div>
<div class="block noborder">
    <h3>EMBEDDED FEEDBACK</h3>
    <div>
        <?=HTML::image('img/embed-feedback-1.png')?>
        <?=HTML::image('img/embed-feedback-2.png')?>
        <?=HTML::image('img/embed-feedback-3.png')?>
        <p>
           Recommended to be integrated as a part of your page or <br />
           as a standalone page, easily accessible by your visitors.<br /> 
           You can choose between a single, two or three column layouts, <br />
           all designed to adapt to your page's layout like they <br />
           were designed especially for it. 
        </p>
        <a href="#" class="customize">CUSTOMIZE</a>
    </div>
    <div class="c"></div>
</div>
<!-- spacer -->
<div class="block noborder" style="height:300px;">
</div>
<!-- spacer -->

