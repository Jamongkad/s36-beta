<input type="hidden" id="theme_name" name="theme_name" value="<?=$panel->theme_name?>" />
<div ng-app="QuickInbox">
<div id="adminWindowBox" ng-controller="AppCtrl" >
    <div id="adminWindowTitleBar">
        <div class="adminTitleText">Admin Panel</div>
        <div class="minBtn"></div>
        <div class="closeBtn"></div>
    </div>
    <div id="adminWindowHolder" >
        <div id="adminWindowMenuBar">
            <ul>
                <li><a href="javascript:;" class="active" initquick>Quick Inbox</a></li>
                <li><a href="javascript:;" class="">Background</a></li>
                <li><a href="javascript:;" class="">Display</a></li>
                <li><a href="javascript:;" class="layoutMenu">Layout</a></li>
                <li><a href="javascript:;" class="">Other Settings</a></li>
            </ul>
        </div>
        <div id="adminWindowPages">
            <div id="quickInbox" class="adminPage" style="height:502px; width:520px">
                <div class="pageContents">
                    <div class="pageTitle">
                        Recent Submitted Feedback
                        <span class="full-inbox-link"> <a href="/inbox/all">Click here to access full inbox</a></span>
                    </div>
                    <div class="pageBody">
                        <div id="quickInboxWidget">
                            <div class="widget-list" scrollpane>
                                <h2 ng-show="!feedbacks.length">No Feedback for today.</h2>
                                <div ui-if="!!feedbacks.length">
                                    <!--quick inbox loop-->
                                    <div class="widget-item clear" ng-repeat="feeds in feedbacks">                                     

                                        <div class="left">
                                            <input type="checkbox" 
                                                   value="{{feeds.id}}"
                                                   name="feedid" 
                                                   ng-checked="is_selected(feeds.id)" 
                                                   ng-click="update_selection($event, feeds.id)"/>
                                        </div>

                                        <div class="right" checkfeed>
                                            <div class="widget-avatar" avatar login="feeds.logintype" pic="feeds.avatar"> 
                                            </div>
                                            <div class="widget-content">
                                                <div class="widget-submitter break-word" checkfeed>
                                                    <span class="name">{{feeds.firstname}} {{feeds.lastname}}</span> 
                                                    <span class="social-src" social login="feeds.logintype"></span>
                                                </div>
                                                <div class="widget-date break-word" checkfeed>
                                                    <span feedbackdate date="{{feeds.date}}"></span>
                                                </div>
                                                <div class="widget-text break-word">
                                                    <p>{{feeds.text}}</p>
                                                    <div infoblock load="{{feeds}}">
                                                        <span metadata load="{{feeds.metadata}}"></span>
                                                        <span attachments load="feeds.attachments" feedid="feeds.id"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--quick inbox loop-->
                                </div>
                            </div>
                        </div>
                        <div class="quick-inbox-spacer"></div>
                        <div id="quickInboxActions">
                            <span>Selected : </span>
                            <input type="button" class="small-button publish" value="Publish" ng-click="admin_action('publish')" feedbackout/>
                            <input type="button" class="small-button feature" value="Feature" ng-click="admin_action('feature')" feedbackout/>
                            <input type="button" class="small-button delete" value="Delete" ng-click="admin_action('delete')" feedbackout/>
                        </div>
                    </div>
                </div>
            </div>
            <div id="background" class="adminPage">
                <div class="pageContents">
                    <?php
                    $pattern_selected   = ($panel->active_background=='pattern') ? true : false;
                    $background_image   = (!empty($panel->background_image)) ? Config::get('application.hosted_background').'/'.$panel->background_image : '';
                    $background_pattern = (!empty($panel->background_pattern)) ? $panel->background_pattern : '';
                    ?>
                    <div class="pageTitle">
                        Page Background
                        <div class="background-chooser">
                            Please Choose : 
                            <select id="selectedBackground">
                                <option value="image" <?=($pattern_selected) ? '' : 'selected="selected"'?>>Background Image</option>
                                <option value="pattern" <?=($pattern_selected) ? 'selected="selected"' : ''?>>Patterns</option>
                            </select>
                        </div> 
                    </div>
                    <div class="pageBody">
                    <div id="backgroundImageOptions" style="display:<?=($pattern_selected) ? 'none' : 'block' ?>">
                        <h2>Background Image</h2>
                        <input id="background_image" type="hidden" value="<?=$background_image?>"/>
                        <div id="bgDragBox" class="">
                            <div id="dragBoxText">
                                <span><strong>Drag your background image here</strong></span>
                                <span>or</span>
                                <!--
                                <span class="uploadBtn"></span>
                                --><input type="file" id="bg_image" data-url="/imageprocessing/upload_hosted_background_image" />
                            </div>
                            <div id="upload-status-area">
                                <div class="upload-preview">
                                    <span>Uploading...</span>
                                    <div class="progress-shade"></div>
                                </div>
                            </div>
                        </div>
                        <!--current background image -->
                        <div class="optionList clear">
                            <span class="label">Current Background: </span>
                            <span id="blankBgImage" <?=(!empty($panel->background_image)) ? 'style="display:none"' : '' ?>></span>
                            <span id="currentBg" <?=(empty($panel->background_image)) ? 'style="display:none"' : '' ?>>
                                <img id="currentBgImage" src="<?=Config::get('application.hosted_background').'/'.$panel->background_image?>"/>
                            </span>
                        </div>
                        <!--end current background image -->
                        <div id="backgroundOptions">
                            <div class="optionList clear">
                                <span class="label">Position: </span>
                                <span>
                                    <a href="javascript:;" id="bg_pos_l" val="left" class="selectionBtn bgPos <?=(strtolower($panel->page_bg_position)=='left') ? 'active' : ''?>">Left</a>
                                    <a href="javascript:;" id="bg_pos_r" val="right" class="selectionBtn bgPos <?=(strtolower($panel->page_bg_position)=='right') ? 'active' : ''?>">Right</a>
                                    <a href="javascript:;" id="bg_pos_c" val="center" class="selectionBtn bgPos <?=(strtolower($panel->page_bg_position)=='center') ? 'active' : ''?>">Center</a>
                                    <a href="javascript:;" id="bg_pos_t" val="top" class="selectionBtn bgPos <?=(strtolower($panel->page_bg_position)=='top') ? 'active' : ''?>">Top</a>
                                    <a href="javascript:;" id="bg_pos_b" val="bottom" class="selectionBtn bgPos <?=(strtolower($panel->page_bg_position)=='bottom') ? 'active' : ''?>">Bottom</a>
                                </span>
                            </div> 
                            <div class="optionList clear">
                                <span class="label">Repeat: </span>
                                <span>
                                    <a href="javascript:;" id="bg_repeat_r" val="repeat" class="selectionBtn bgRepeat <?=(strtolower($panel->page_bg_repeat)=='repeat') ? 'active' : ''?>">Repeat</a>
                                    <a href="javascript:;" id="bg_repeat_rh" val="repeat-x" class="selectionBtn bgRepeat <?=(strtolower($panel->page_bg_repeat)=='repeat-x') ? 'active' : ''?>">Repeat Horizontally</a>
                                    <a href="javascript:;" id="bg_repeat_rv" val="repeat-y" class="selectionBtn bgRepeat <?=(strtolower($panel->page_bg_repeat)=='repeat-y') ? 'active' : ''?>">Repeat Vertically</a>
                                    <a href="javascript:;" id="bg_repeat_nr" val="no-repeat" class="selectionBtn bgRepeat <?=(strtolower($panel->page_bg_repeat)=='no-repeat') ? 'active' : ''?>">No Repeat</a>
                                </span>
                            </div> 
                        </div>
                        <br />
                    </div>
                    <!-- end of backround image upload -->
                    <div id="backgroundPatternOptions" style="display:<?=($pattern_selected) ? 'block' : 'none' ?>">
                        <h2>Option Pattern</h2>
                        <input id="background_pattern" type="hidden" value="<?=$background_pattern?>"/>
                        <br />
                        <div class="patternList jcarousel-skin-tango">
                            <ul id="patterns" class="patternList clear">
                                <?php foreach($patterns as $pattern): ?>
                                <li><div id="<?=$pattern['basename']?>" class="patternItem <?=($panel->background_image==$pattern['basename']) ? 'active' : ''?>" style="background:url(<?=$pattern['path']?>)"></div></li>   
                                <?php endforeach; ?>
                            </ul>
                            <div class="patternPagination">
                                <div id="patternPrev"></div> <div id="patternNext"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end of backround pattern upload -->
                        <br />
                        <h2>Background Color</h2>
                        <br />
                        <div class="backgroundChooser">
                            <input type="minicolors" data-textfield="false" data-opacity="<?=(isset($panel->page_bg_color_opacity) ? $panel->page_bg_color_opacity :'.75' )?>" value="<?=(isset($panel->page_bg_color) ? $panel->page_bg_color :'#FFFFFF' )?>" class="backgroundColorPicker" style="visibility:hidden" />
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
                        <div id="adminDisplayOptionGeneralItems">
                         <div class="display-stars clear">
                             <div class="stars blue clear">
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star full"></div>
                                    <div class="star half"></div>    
                                </div>
                            </div>
                            <div class="display-useful-count clear">
                                <div class="rating-stat">
                                    98 people found this useful
                                </div>
                            </div>
                            <div class="display-recommendation clear">
                             <div class="feedback-recommendation">
                                    <div class="green-thumb">Recommended by Leica to friends</div>
                                </div>
                            </div>
                        </div>
                        <div id="adminDisplayOptionAuthorItems">
                         <div class="display-author clear">
                             <div class="author-avatar">
                                <img src="fullpage/common/img/blank.jpg" width="48" height="48"/>
                                </div>
                                <div class="author-information">
                                    <div class="author-name clear">
                                        <span class="first_name">John</span>
                                        <span class="last_name">Doe</span>
                                        <span class="last_name_ini">D.</span>
                                    </div>
                                    <div class="author-company">
                                        <span class="job">Position<span class="company_comma">, </span></span>
                                        <span class="company">Company</span>
                                    </div>
                                    <div class="author-location-info clear">
                                        <div class="author-location">
                                            <span class="city">City<span class="location_comma">, </span></span>
                                            <span class="country">Country</span>
                                        </div>
                                        <div class="flag flag-us"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="display-option-box">
                            <h2>General Items</h2>
                            <p><span class="tickerbox <?= ($panel->show_rating == 0 ? 'off' : ''); ?>" field="show_rating" display-array="stars,star_rating"></span> <span class="label">Display Rating Stars - Based on X Reviews </span></p>
                            <p><span class="tickerbox <?= ($panel->show_votes == 0 ? 'off' : ''); ?>" field="show_votes" display-array="rating-stat,vote-action"></span> <span class="label">Display 'X found this useful'</span> </p>
                            <p><span class="tickerbox <?= ($panel->show_recommendation == 0 ? 'off' : ''); ?>" field="show_recommendation" display-array="green-thumb,company-recommendation"></span> <span class="label">Display 'Recommended to friends' text</span> </p>
                            
                            <h2>Display Meta Information</h2>
                            <p><span class="tickerbox <?= ($panel->show_metadata == 0 ? 'off' : ''); ?>" field="show_metadata" display-array="custom-meta-data"></span> <span class="label">Display Custom Field</span> </p>
                            
                            <h2>Display Admin Comment</h2>
                            <p><span class="tickerbox <?= ($panel->show_admin_comment == 0 ? 'off' : ''); ?>" field="show_admin_comment" display-array="admin-comment-block"></span> <span class="label">Disable or enable public admin commenting</span> </p>
                            
                            <h2>Sharing Options</h2>
                            <p><span class="tickerbox <?= ($panel->show_sharing_option == 0 ? 'off' : ''); ?>" field="show_sharing_option" display-array="share-button"></span> <span class="label">Enable Feedback sharing options by Facebook/Twitter</span> </p>
                            
                            <h2>Display 'Flag as inappropriate' Option</h2>
                            <p><span class="tickerbox <?= ($panel->show_flag_inapp == 0 ? 'off' : ''); ?>" field="show_flag_inapp" display-array="flag_control"></span> <span class="label">Allows users to report inappropiate feedback to your administrative team</span> </p>
                            
                            <h2>User Display Information</h2>
                            <p><span class="tickerbox <?= ($panel->show_avatar == 0 ? 'off' : ''); ?>" field="show_avatar" display-array="author-avatar"></span> <span class="label">Display Avatar</span> </p>
                            <p><span class="tickerbox <?= ($panel->show_last_name_as_ini == 0 ? 'off' : ''); ?>" field="show_last_name_as_ini" display-array="last_name_ini"></span> <span class="label">Display Last Name as initial</span> </p>
                            <p><span class="tickerbox <?= ($panel->show_position == 0 ? 'off' : ''); ?>" field="show_position" display-array="job"></span> <span class="label">Display Job Position</span> </p>
                            <p><span class="tickerbox <?= ($panel->show_company == 0 ? 'off' : ''); ?>" field="show_company" display-array="company,company_comma"></span> <span class="label">Display Company Name</span> </p>
                            <p><span class="tickerbox <?= ($panel->show_city == 0 ? 'off' : ''); ?>" field="show_city" display-array="city"></span> <span class="label">Display City</span> </p>
                            <p><span class="tickerbox <?= ($panel->show_country == 0 ? 'off' : ''); ?>" field="show_country" display-array="country,location_comma"></span> <span class="label">Display Country</span> </p>
                            <p><span class="tickerbox <?= ($panel->show_flag == 0 ? 'off' : ''); ?>" field="show_flag" display-array="flag"></span> <span class="label">Display Country Flag</span> </p>
                            
                            <h2>Attachment Options</h2>
                            <p><span class="tickerbox <?= ($panel->show_image_attachment == 0 ? 'off' : ''); ?>" field="show_image_attachment" display-array="uploaded-images"></span> <span class="label">Display Image Attachments</span> </p>
                            <p><span class="tickerbox <?= ($panel->show_video_attachment == 0 ? 'off' : ''); ?>" field="show_video_attachment" display-array="uploaded-link,uploaded-video"></span> <span class="label">Display Video Attachments</span> </p>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="layout" class="adminPage">
                <div class="pageContents">
                    <div class="pageTitle">
                        Layout
                    </div>
                    <div class="pageBody clear">
                        
                            <ul class="layout-list clear">
                                <li <?=($panel->theme_name=='Traditional') ? 'class="selected"' : ''?> id="Traditional">
                                    <div class="layout">
                                        <h3 class="layout-name">Traditional</h3>
                                        <div class="layout-thumb">
                                            <img src="fullpage/admin/img/layout-thumb-traditional.jpg" />
                                        </div>
                                    </div>
                                </li>
                                <li <?=($panel->theme_name=='Timeline') ? 'class="selected"' : ''?> id="Timeline">
                                    <div class="layout">
                                        <h3 class="layout-name">Timeline</h3>
                                        <div class="layout-thumb">
                                            <img src="fullpage/admin/img/layout-thumb-timeline.jpg" />
                                        </div>
                                    </div>
                                </li>
                                <li <?=($panel->theme_name=='Treble') ? 'class="selected"' : ''?> id="Treble">
                                    <div class="layout">
                                        <h3 class="layout-name">Treble</h3>
                                        <div class="layout-thumb">
                                            <img src="fullpage/admin/img/layout-thumb-treble.jpg" />
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <p align="right"><input type="hidden" id="selectedLayout" value="Traditional" /><input id="chooseLayout" type="button" class="regular-button" value="Choose Layout" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        
                    </div>
                </div>
            </div>
            <div id="descriptionAndColors" class="adminPage">
                <div class="pageContents">
                    <div class="pageTitle">
                        Header Options
                    </div>
                    <div class="pageBody">
                        <div class="optionList clear">
                            <div class="label"><strong>Company/Brand Description</strong> </div>
                            <div class="input">
                                <p id="desc_hint" style="<?= (trim($panel->description) == '' ? '' : 'display: none;'); ?>">
                                    This will be shown on your main public page
                                </p>
                                <? // keep the content of companyDescription in one line. ?>
                                <div id="panel_desc_container" class="rounded_corner">
                                    <p class="companyDescription break-word"><?= nl2br(HTML::entities($panel->description)); ?></p>
                                </div>
                                <textarea id="panel_desc_textbox"></textarea>
                            </div>
                        </div>
                        <div class="pageTitle">
                            Social Media
                        </div>
                        <div class="optionList clear">
                            <div class="label"><strong>Facebook URL: </strong> </div>
                            <div class="input">
                                <input type="text" id="fb_url" class="social_url" maxlength="255" value="<?= $panel->facebook_url; ?>" />
                                <span id="fb_url_error_msg" class="social_url_msg error_msg rounded_corner">Invalid URL</span>
                                <span id="fb_url_success_msg" class="social_url_msg success_msg rounded_corner">URL is valid</span>
                            </div>
                        </div>
                        <div class="optionList clear">
                            <div class="label"><strong>Twitter URL: </strong> </div>
                            <div class="input">
                                <input type="text" id="tw_url" class="social_url" maxlength="255" value="<?= $panel->twitter_url; ?>" />
                                <span id="tw_url_error_msg" class="social_url_msg error_msg rounded_corner">Invalid URL</span>
                                <span id="tw_url_success_msg" class="social_url_msg success_msg rounded_corner">URL is valid</span>
                            </div>
                        </div>
                        <div class="pageTitle">
                            Button
                        </div>
                        <div class="optionList clear">
                            <?php
                                $button_bg_color        = ( ! is_null($panel->button_bg_color) ? $panel->button_bg_color : '#e3540f' );
                                $button_hover_bg_color  = ( ! is_null($panel->button_hover_bg_color) ? $panel->button_hover_bg_color : '#f26724' );
                                $button_font_color      = ( ! is_null($panel->button_font_color) ? $panel->button_font_color : '#ffffff' );
                            ?>
                            <div class="grids">
                                <div class="g1of4">
                                    <div><strong>Background Color</strong> </div>
                                    <div>
                                        <br />
                                        <div class="backgroundChooser">
                                            <!-- <input type="minicolors" class="btnBgColor" data-textfield="false" value="<?= $panel->button_bg_color; ?>" style="visibility:hidden" /> -->
                                            <input type="minicolors" class="btnBgColor" data-textfield="false" value="<?php echo $button_bg_color; ?>" style="visibility:hidden" />
                                        </div>
                                    </div>
                                </div>
                                <div class="g3of4">
                                    <div><strong>Mouseover Bg Color</strong></div>
                                    <div>
                                        <br />
                                        <div class="backgroundChooser">
                                            <!-- <input type="minicolors" class="mbtnBgColor" data-textfield="false" value="<?= $panel->button_hover_bg_color; ?>" style="visibility:hidden" /> -->
                                            <input type="minicolors" class="mbtnBgColor" data-textfield="false" value="<?php echo $button_hover_bg_color; ?>" style="visibility:hidden" />
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
                                            <!-- <input type="minicolors" class="btnFontColor" data-textfield="false" value="<?= $panel->button_font_color; ?>" style="visibility:hidden" /> -->
                                            <input type="minicolors" class="btnFontColor" data-textfield="false" value="<?php echo $button_font_color; ?>" style="visibility:hidden" />
                                        </div>                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

