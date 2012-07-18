<?=Form::hidden('submit_widgetkey', $widget->widgetkey)?>
<?if($widget_type == 'Widget\Entities\Types\FormWidgets'):?>
    <?=Form::hidden('tab_type', $widget->tab_type, Array('id' => 'selected-tab'))?>
<?endif?>
<span id="update-tabtype-url" hrefaction="<?=URL::to('feedsetup/update_tabtype/')?>"></span>

<script type="text/javascript">
$(function(){    
    $('#formcodebox ul li').click(function(){
        $(this).parent().find('li').each(function(){
            $(this).removeClass('active');
        });
        display_codes($(this).index() + 1);
        $(this).addClass('active');
    });
    
    $('.highlight').focus(function() {
        $this = $(this);

        $this.select();

        window.setTimeout(function() {
            $this.select();
        }, 1);

        // Work around WebKit's little problem
        $this.mouseup(function() {
            // Prevent further mouseup intervention
            $this.unbind("mouseup");
            return false;
        });
    });
});

function display_codes(i){
    $('.formcodeboxcontainer').each(function(){
        $(this).hide();
    });
    $('#formcodeboxcontent'+i).fadeIn('fast');
}
</script>

<div class="block">
    <h2 style="margin-left:-8px;color:#3d6285;font-size:17px;">Form Code Manager</h2>
    <br/>
    <div id="widget-setup-block">
        <div class="widget-options" style="padding-bottom:0px;border:1px solid #f0f2f3">
            <div id="formcodebox">                    
                <ul>
                  <?if($widget_type == 'Widget\Entities\Types\FormWidgets'):?>
                      <li class="formcodelink1 active" >Image Tabs <div class="formcodearrow"></div></li>
                      <li class="formcodelink2">Embed Form Code <div class="formcodearrow"></div></li>
                      <li class="formcodelink3">Popup Form Link <div class="formcodearrow"></div></li>
                      <li class="formcodelink4">Link to Form <div class="formcodearrow"></div></li>
                  <?else:?>
                      <li class="formcodelink1 active">Embed Code <div class="formcodearrow"></div></li>
                      <li class="formcodelink2">Link to Display <div class="formcodearrow"></div></li>
                  <?endif?>
                </ul> 
                <div id="formcodeboxcontent">
                  <?if($widget_type == 'Widget\Entities\Types\FormWidgets'):?>
                    <div id="formcodeboxcontent1" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        <strong>Floating Tab Position : 
                            <select id="tab-position" class="regular-select" style="font-size:12px;padding:5px;">
                                <?php 
                                    preg_match('~tab-(br|bl|tr|tl|r|l)~', $widget->tab_type, $match);
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
                                    $positions[$v] = $themes;
                                }

                                Helpers::dump($positions);
                               
                                /*
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
                                */ 
                            ?> 
                        </div>

                        <table width="400" align="center">
                        <tr><td><strong>JavaScript Version</strong></td></tr>
                        <tr><td><textarea class="regular-text highlight" rows="7">
<?=$embed_js_code;?> 
                        </textarea></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent2" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        
                        <table width="400" align="center">
                        <tr><td><strong>JavaScript Version <small>(Recommended)</small></strong></td></tr>
                        <!--JS Link Pop code goes here-->
                        <tr><td><textarea class="regular-text highlight" rows="7">
<?=$embed_js_code;?> 
                        </textarea></td></tr>  
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent3" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        
                        <table width="400" align="center"> 
                        <tr><td><strong>JavaScript Version <small>(Recommended)</small></strong></td></tr>
                        <tr><td><textarea class="regular-text highlight" rows="7">
<?=$link_js_output;?>
                        </textarea></td></tr>

                        <tr><td><strong>HTML Popup Version</strong></td></tr>
                        <tr><td><textarea class="regular-text highlight" rows="7">
<?=$link_native_output;?>
                        </textarea></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent4" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste Code Snippets to <br />
                        Create a Link to Your Form</h4>
                        
                        <table width="400" align="center">
                        <tr><td><strong>Permanent Shortlink URL</strong></td></tr>
                        <tr><td><input type="text" class="regular-text highlight" value="<?=$loader_url?>"/></td></tr>
                        <tr height="10"><td></td></tr>
                        <tr><td><strong>Use this HTML Link in a Webpage</strong></td></tr>
                        <tr><td><input type="text" class="regular-text highlight" 
                                       value="<a href='<?=$loader_url?>'>Fill out my form!</a>"/></td></tr>
                        </table>
                    </div>
                  <?else:?>
                    <div id="formcodeboxcontent1" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        
                        <table width="400" align="center">
                        <tr><td><strong>JavaScript Version <small>(Recommended)</small></strong></td></tr>
                        <!--JS Link Pop code goes here-->
                        <tr><td><textarea class="regular-text highlight" rows="7">
<?=$embed_js_code;?> 
                        </textarea></td></tr>  

                        <tr><td><strong>HTML Popup Version</strong></td></tr>
                        <tr><td><textarea class="regular-text highlight" rows="7">
<?=$iframe_code;?>
                        </textarea></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent2" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste Code Snippets to <br />
                        Create a Link to Your Form</h4>
                        
                        <table width="400" align="center">
                        <tr><td><strong>Permanent Shortlink URL</strong></td></tr>
                        <tr><td><input type="text" class="regular-text highlight" value="<?=$loader_url?>"/></td></tr>
                        <tr height="10"><td></td></tr>
                        <tr><td><strong>Use this HTML Link in a Webpage</strong></td></tr>
                        <tr><td><input type="text" class="regular-text highlight" 
                                       value="<a href='<?=$loader_url?>'>Fill out my form!</a>"/></td></tr>
                        </table>
                    </div>
 
                  <?endif?>
                </div> 
            </div>
        </div>
    </div>
</div>
