<div id="adminWindowBox">
	<div id="adminWindowTitleBar">
    	<div class="adminTitleText">Admin Panel</div>
        <div class="minBtn"></div>
        <div class="closeBtn"></div>
    </div>
    <div id="adminWindowHolder">
        <div id="adminWindowMenuBar">
            <ul>
                <li><a href="javascript:;" class="active">Background</a></li>
                <li><a href="javascript:;" class="">Display</a></li>
                <li><a href="javascript:;" class="">Description &amp; Colors</a></li>
                <li><a href="javascript:;" class="">Social Media</a></li>
            </ul>
        </div>
        <div id="adminWindowPages">
            <div id="background" class="adminPage">
                <div class="pageContents">
                    <div class="pageTitle">
                        Page Background 
                    </div>
                    <div class="pageBody">
                        
                        <h2>Upload Image</h2>
                        <div id="bgDragBox" class="">
                            <div id="dragBoxText">
                                <span><strong>Drag your background image here</strong></span>
                                <span>or</span>
                                <!--
                                <span class="uploadBtn"></span>
                                --><input type="file" id="bg_image" data-url="server/" />
                            </div>
                            <div id="upload-status-area">
                                <div class="upload-preview">
                                    <span>Uploading...</span>
                                    <div class="progress-shade"></div>
                                </div>
                            </div>
                        </div>
                        <div id="backgroundOptions">
                            <div class="optionList clear">
                                <span class="label">Position: </span>
                                <span>
                                    <a href="javascript:;" id="bg_pos_l" class="selectionBtn bgPos active">Left</a>
                                    <a href="javascript:;" id="bg_pos_r" class="selectionBtn bgPos">Right</a>
                                    <a href="javascript:;" id="bg_pos_c" class="selectionBtn bgPos">Center</a>
                                    <a href="javascript:;" id="bg_pos_t" class="selectionBtn bgPos">Top</a>
                                    <a href="javascript:;" id="bg_pos_b" class="selectionBtn bgPos">Bottom</a>
                                </span>
                            </div> 
                            <div class="optionList clear">
                                <span class="label">Repeat: </span>
                                <span>
                                    <a href="javascript:;" id="bg_repeat_r" class="selectionBtn bgRepeat">Repeat</a>
                                    <a href="javascript:;" id="bg_repeat_rh" class="selectionBtn bgRepeat active">Repeat Horizontally</a>
                                    <a href="javascript:;" id="bg_repeat_rv" class="selectionBtn bgRepeat">Repeat Vertically</a>
                                    <a href="javascript:;" id="bg_repeat_nr" class="selectionBtn bgRepeat">No Repeat</a>
                                </span>
                            </div> 
                        </div>
                        <br />
                        <h2>Option Pattern</h2>
                        <br />
                        <div class="patternList jcarousel-skin-tango">
                            <ul id="patterns" class="patternList clear">
                                <?php foreach($patterns as $pattern): ?>
                                <li><div id="<?=$pattern['basename']?>" class="patternItem" style="background:url(<?=$pattern['path']?>)"></div></li>	
                                <?php endforeach; ?>
                            </ul>
                            <div class="patternPagination">
                                <div id="patternPrev"></div> <div id="patternNext"></div>
                            </div>
                        </div>
                        <br />
                        <h2>Background Color</h2>
                        <br />
                        <div class="backgroundChooser">
                            <input type="minicolors" data-textfield="false" data-opacity=".75" value="#FFFFFF" class="backgroundColorPicker" style="visibility:hidden" />
                        </div>                    
                    </div>
                </div>
            </div>
            <div id="displayOptions" class="adminPage">
                <div class="pageContents">
                    <div class="pageTitle">
                        Page Display Information
                        <span class="light-text">Customize your page display here</span>
                    </div>
                    <div class="pageBody">
                        <div class="display-option-box">
                            <h2>General Items</h2>
                            <p><span class="tickerbox" display-array="stars"></span> <span class="label">Display Rating Stars - Based on X Reviews </span></p>
                            <p><span class="tickerbox" display-array="rating-stat,feedback-action"></span> <span class="label">Display 'X found this useful'</span> </p>
                            <p><span class="tickerbox" display-array="feedback-recommendation"></span> <span class="label">Display 'Recommended to friends' text</span> </p>
                            
                            <h2>Display Meta Information</h2>
                            <p><span class="tickerbox" display-array="custom-meta-data"></span> <span class="label">Display Custom Field</span> </p>
                            
                            <h2>Display Admin Comment</h2>
                            <p><span class="tickerbox" display-array="admin-comment-block"></span> <span class="label">Disable or enable public admin commenting</span> </p>
                            
                            <h2>Sharing Options</h2>
                            <p><span class="tickerbox" display-array="share-button"></span> <span class="label">Enable Feedback sharing options by Facebook/Twitter</span> </p>
                            
                            <h2>Display 'Flag as inappropriate' Option</h2>
                            <p><span class="tickerbox" display-array="flag-as"></span> <span class="label">Allows users to report inappropiate feedback to your administrative team</span> </p>
                            
                            <h2>User Display Information</h2>
                            <p><span class="tickerbox" display-array="first_name"></span> <span class="label">Display First Name</span> </p>
                            <p><span class="tickerbox" display-array="last_name"></span> <span class="label">Display Last Name</span> </p>
                            <p><span class="tickerbox" display-array="job,company_comma"></span> <span class="label">Display Job Position</span> </p>
                            <p><span class="tickerbox" display-array="company,company_comma"></span> <span class="label">Display Company Name</span> </p>
                            <p><span class="tickerbox" display-array="city,location_comma"></span> <span class="label">Display City</span> </p>
                            <p><span class="tickerbox" display-array="country,location_comma"></span> <span class="label">Display Country</span> </p>
                            <p><span class="tickerbox" display-array="flag"></span> <span class="label">Display Country Flag</span> </p>
                            
                            <h2>Attachment Options</h2>
                            <p><span class="tickerbox" display-array="uploaded-images"></span> <span class="label">Display Image Attachments</span> </p>
                            <p><span class="tickerbox" display-array="uploaded-link,uploaded-video"></span> <span class="label">Display Video Attachments</span> </p>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="descriptionAndColors" class="adminPage">
                <div class="pageContents">
                    <div class="pageTitle">
                        Description
                    </div>
                    <div class="pageBody">
                        <div class="optionList clear">
                            <div class="label"><strong>Text</strong> </div>
                            <div class="input">
                                <p class="companyDescription">Our company strives to bring only the best possible products and services suitable for our clients specific needs. Our business is simple: you describe, we create. Visit us at www.charleskeith.com today and experience the love.</p>
                            </div>
                        </div>
                        <div class="optionList clear">
                            <div class="label"><strong>Font Size</strong> </div>
                            <div class="input">
                                <select>
                                    <option>12</option>
                                    <option>14</option>
                                    <option>16</option>
                                </select>
                            </div>
                        </div>
                        <br />
                        <div class="pageTitle">
                            Button
                        </div>
                        <div class="optionList clear">
                            <div class="grids">
                                <div class="g1of4">
                                    <div><strong>Background Color</strong> </div>
                                    <div>
                                        <br />
                                        <div class="backgroundChooser">
                                            <input type="minicolors" class="btnBgColor" data-textfield="false" value="#E3540F" style="visibility:hidden" />
                                        </div>
                                    </div>
                                </div>
                                <div class="g3of4">
                                    <div><strong>Mouseover Bg Color</strong></div>
                                    <div>
                                        <br />
                                        <div class="backgroundChooser">
                                            <input type="minicolors" class="mbtnBgColor" data-textfield="false" value="#E3540F" style="visibility:hidden" />
                                        </div>						
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="grids">
                                <div class="g3of4">
                                    <div><strong>Font Color</strong></div>
                                    <div>
                                        <br />
                                        <div class="backgroundChooser">
                                            <input type="minicolors" class="btnFontColor" data-textfield="false" value="#FFFFFF" style="visibility:hidden" />
                                        </div>						
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="socialMedia" class="adminPage">
                <div class="pageContents">
                    <div class="pageTitle">
                        Social Media
                    </div>
                    <div class="pageBody">
                        
                            <h2>Facebook URL: </h2>
                            <br />
                            <span>
                                <input type="text" />
                            </span>
                            <br /><br />
                            <h2>Twitter URL: </h2>
                            <br />
                            <span>
                                <input type="text" />
                            </span>
                            <br /><br />
                            <input type="button" class="regular-button" value="Save Links" />
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="notification">
	<div id="notification-design">
    	<div id="notification-message">
        	Loading... Please Wait... you bits.
        </div>
    </div>
</div>