<?=Form::open('feedsetup/save_form_widget', 'POST', array('id' => 'create-form-widget'))?>
<?$site_id = Input::get('site_id')?>
<?=Form::hidden('company_id', $widget->companyid)?>
<?=Form::hidden('widgetkey', $widget->widgetkey)?>
<?=Form::hidden('theme_type', $widget->widgetobj->theme_type, Array('id' => 'selected-form'))?>
<?=Form::hidden('tab_type', $widget->widgetobj->tab_type, Array('id' => 'selected-tab'))?>
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
                            <td><input type="text" class="large-text" name="theme_name" value="<?=$widget->widgetobj->theme_name?>" title="Name your form" /></td>
                        </tr>
                        <tr>
                            <td>
                                <strong style="font-size:14px;">Flavor Text :</strong>
                            </td>
                            <td><input type="text" class="large-text" name="form_text" value="<?=$widget->widgetobj->form_text?>" title="ex. Give us your feedback" /></td>
                        </tr>
                        <tr>
                            <td>
                                <strong style="font-size:14px;">What to write :</strong>
                            </td>
                            <td><input type="text" class="large-text" name="form_question" value="<?=$widget->widgetobj->form_question?>" title="ex. How do you feel about our products?" /></td>
                        </tr>
                    </table>
            </div>
        </div>
        <div class="widget-options">
            <h2><span>Step 2 :</span> Choose your website you want to apply your Widget to</h2>
            <div style="padding:10px">
                <select name="site_id" id="feedsetup-site-select" class="regular-select" hrefaction="<?=URL::to('feedsetup/render_display_info')?>" style="font-size:15px"> 
                    <?foreach($site as $sites):?>
                        <option value="<?=$sites->siteid?>" <?=($widget->siteid== $sites->siteid) ? 'selected' : null?>><?=$sites->domain?></option>
                    <?endforeach?>
                </select>
                <div id="site_id" class="error-msg"></div>
            </div>
        </div>
        <div class="widget-options"> 
            <h2><span>Step 3 :</span> Select a theme for both your feedback form and floating tab</h2>
            <div class="widget-types">
                <strong style="font-size:14px;">Form Theme Design :</strong>
                <div class="widget-info" style="margin:0px -20px;">
                    <div class="form-design-slide">
                        <div class="form-design-prev">
                        </div>
                        <div class="form-designs grids">
                        <?php
                            $form_slides = '';
                            $units = 7;
                            $ctr = 0;
                            $max = count($form_themes );
                            
                            foreach($form_themes  as $form_colors => $val){
                                if(($ctr % $units) == 0){
                                    $form_slides .= '<div class="form-design-group grids">';
                                    $end = 1;
                                }
                                    $color_name = 'form-'.$form_colors;
                                    $form_slides .= '<div class="form-design" id="'.$color_name.'">
                                                        <img src="/img/tab-designs/'.$form_colors.'-form.png" height="60" />
                                                        <span>'.$val.'</span>
                                                        <div id="preview" class="preview button-gray" hrefaction="'.URL::to('feedsetup/preview_widget_style')
                                                                 .'/'.$color_name.'">
                                                            Preview
                                                        </div>
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
                </div>
                <br />
                <strong style="font-size:14px;">Floating Tab Position : 
                    <select id="tab-position" class="regular-select" style="font-size:12px;padding:5px;">
                    <?php 
                        preg_match('~tab-(br|bl|tr|tl|r|l)~', $widget->widgetobj->tab_type, $match);
                        $select = Array(
                            'l' => 'Left Side Tab'
                          , 'r' => 'Right Side Tab'
                          , 'tr' => 'Top Right Corner'
                          , 'tl' => 'Top Left Corner'
                          , 'br' => 'Bottom Right Corner'
                          , 'bl' => 'Bottom Left Corner'
                        );


                        $string = "";

                        foreach($select as $key => $value) {
                            $string .= "<option value='$key' ".(($key == $match[1]) ? "selected" : null).">$value</option>";
                        }

                        echo $string;      
                    ?>
                    </select>
                </strong>
                <div class="widget-info" style="margin:0px -20px;"></div>
                <br />
                <strong style="font-size:14px;">Tab Design : </strong>
                <div id="tab-slider" class="widget-info" style="margin:0px -20px;">
                
                <?php
                      
                    $positions = Array();
                    foreach(Array('r', 'l', 'br', 'bl', 'tr', 'tl') as $v) {
                        $positions[$v] = $form_themes;
                    }

                    $theme_slides = '';
                    foreach($positions as $pos => $theme){
                        $theme_slides .= '<div class="'.$pos.'-design-slide">
                                      <div class="'.$pos.'-design-prev">
                                      </div>
                                      <div class="'.$pos.'-designs grids">';
                                        $units = 7;
                                        $ctr = 0;
                                        $max = count($form_themes);
                                        
                                        foreach($theme as $key => $val){
                                            
                                            if(($ctr % $units) == 0){
                                                $theme_slides .= '<div class="form-design-group grids">';
                                                $end = 1;
                                            }
                                            $theme_slides .= '<div class="tab-design" id="tab-'.$pos.'-'.$key.'">
                                                            <img src="/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png" height="60" />
                                                            <br />
                                                            <span>'.$val.'</span>
                                                        </div>';
                                            
                                            if(($end == $units) || $ctr == ($max - 1)){
                                                $theme_slides .= '</div>';
                                            }
                                            
                                            $end++;
                                            $ctr++;
                                        }
                                        
                                $theme_slides .= '</div>
                                        <div class="'.$pos.'-design-next">
                                        </div>
                                    </div>';
                    }
                    echo $theme_slides;	
                ?>
                </div>
            </div>
        </div>

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

                <span id="preview-widget" hrefaction="<?=URL::to('/feedsetup/generate_code')?>"></span>
                <a href="javascript;;" class="button-gray" id="edit-widget-btn">Edit Widget</a>
            </div>    

        </div> 

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
