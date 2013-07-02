<?php
    //echo "<pre>";print_r($panel);echo "</pre>";
    $pattern_selected   = ($panel->active_background=='pattern') ? true : false;
    $background_image   = (!empty($panel->background_image)) ? Config::get('application.hosted_background').'/'.$panel->background_image : '';
    $background_pattern = (!empty($panel->background_pattern)) ? $panel->background_pattern : '';
?>
<div id="theFormSetup" class="dashboard-page">
	<h1>Page Background</h1>
    <div class="dashboard-box">
    	<div class="dashboard-head">
        <span class="dashboard-title">Please Choose : </span> <span class="dashboard-subtitle">
            <select id="selectedBackground">
                <option value="image" <?=($pattern_selected) ? '' : 'selected="selected"'?>>Background Image</option>
                <option value="pattern" <?=($pattern_selected) ? 'selected="selected"' : ''?>>Patterns</option>
            </select>
        </span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">

                <div id="backgroundImageOptions" class="form-setup-block" style="display:<?=($pattern_selected) ? 'none' : 'block' ?>">
                    <input id="background_image" type="hidden" value="<?=$background_image?>"/>
                    <div id="bgDragBox" class="">
                        <div id="dragBoxText">
                            <span><strong>Drag your background image here</strong></span>
                            <span>or</span>
                            <!--
                            <span class="uploadBtn"></span>
                            -->
                            <input type="file" id="bg_image" data-url="/imageprocessing/upload_hosted_background_image">
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
                </div>


            	<div id="backgroundPatternOptions" class="form-setup-block" style="display:<?=($pattern_selected) ? 'block' : 'none' ?>">
                <input id="background_pattern" type="hidden" value="<?=$background_pattern?>"/>
                   <div class="patternList jcarousel-skin-tango">
                        <div class="jcarousel-container jcarousel-container-horizontal" style="position: relative; display: block;">
                            <div class="jcarousel-clip jcarousel-clip-horizontal" style="position: relative;">
                                <ul id="patterns" class="patternList clear">
                                    <?php foreach($display_patterns as $pattern): ?>
                                    <li>
                                        <div id="<?=$pattern['basename']?>" class="patternItem <?=($panel->background_pattern==$pattern['basename']) ? 'active' : ''?>" style="background:url(/<?=$pattern['path']?>)"></div>
                                    </li>   
                                    <?php endforeach; ?>

                                </ul>
                            </div>
                            <div id="patternNext" class="jcarousel-prev jcarousel-prev-horizontal jcarousel-prev-disabled jcarousel-prev-disabled-horizontal" style="display: block;" disabled="disabled"></div><div id="patternPrev" class="jcarousel-next jcarousel-next-horizontal jcarousel-next-disabled jcarousel-next-disabled-horizontal" style="display: block;" disabled="disabled"></div>
                        </div>
                            <div class="patternPagination"></div>
                    </div>
                </div>

                <div class="form-setup-block">
                    </br>
                    <h2>Background Color</h2>
                    <br />
                    <div class="backgroundChooser">
                            <input type="minicolors" data-textfield="false" data-opacity="<?=(isset($panel->page_bg_color_opacity) ? $panel->page_bg_color_opacity :'.75' )?>" value="<?=(isset($panel->page_bg_color) ? $panel->page_bg_color :'#FFFFFF' )?>" class="backgroundColorPicker" style="visibility:hidden" />
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?=$fullpage_css?>