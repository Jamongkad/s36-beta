<?=Form::hidden('tab_type', 'tab-l-aglow', Array('id' => 'selected-tab'))?>
<script type="text/javascript">
$(function(){
    
    $('#formcodebox ul li').click(function(){
        $(this).parent().find('li').each(function(){
            $(this).removeClass('active');
        });
        display_codes($(this).index() + 1);
        $(this).addClass('active');
    });
    
});

function display_codes(i){
    $('.formcodeboxcontainer').each(function(){
        $(this).hide();
    });
    $('#formcodeboxcontent'+i).fadeIn('fast');
}

</script>

<div class="block" style="margin-top:-25px">
    <div id="widget-setup-block" style="background:#778692;">
        <div class="widget-options">
            <h2><span>Form Code Manager</span></h2>
            <div id="formcodebox">                    
                <ul>
                    <li class="formcodelink1 active">Link to Form</li>
                    <li class="formcodelink2">Embed Form Code</li>
                    <li class="formcodelink3">Popup Form Link</li>
                    <li class="formcodelink4">Image Tabs</li>
                </ul> 
                <div id="formcodeboxcontent">
                    <div id="formcodeboxcontent1" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste Code Snippets to <br />
                        Create a Link to Your Form</h4>
                        
                        <table width="400" align="center">
                        <tr><td><strong>Permanent Shortlink URL</strong></td></tr>
                        <tr><td><input type="text" class="regular-text" /></td></tr>
                        <tr height="10"><td></td></tr>
                        <tr><td><strong>Use this HTML Link in a Webpage</strong></td></tr>
                        <tr><td><input type="text" class="regular-text" /></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent2" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        
                        <table width="400" align="center">
                        <tr><td><strong>JavaScript Version <small>(Recommended)</small></strong></td></tr>
                        <tr><td><textarea class="regular-text" rows="7"></textarea></td></tr>
                        <tr height="10"><td></td></tr>
                        <tr><td><strong>iFrame version</strong></td></tr>
                        <tr><td><textarea class="regular-text" rows="7"></textarea></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent3" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        
                        <table width="400" align="center">
                        <tr><td><textarea class="regular-text" rows="7"></textarea></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent4" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        <strong>Floating Tab Position : 
                            <select id="tab-position" class="regular-select" style="font-size:12px;padding:5px;">
                                <?php 
                                    preg_match('~tab-(br|bl|tr|tl|r|l)~', "tab-l", $match);
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
                        <div id="tab-slider" style="margin:0px 0px;">
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
                                                    $units = 5;
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

                        <table width="400" align="center">
                        <tr><td><textarea class="regular-text" rows="7"></textarea></td></tr>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
        <!--
        <div class="widget-options">
            <div class="block noborder" style="margin-left:-10px;">
                <input type="submit" class="large-btn create-widget-button" value="Save" />
                <input type="submit" class="large-btn preview-form-widget-button" value="Preview Form" />
            </div>
        </div>
        -->
    </div>
</div>
