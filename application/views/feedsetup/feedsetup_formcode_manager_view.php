<?=Form::hidden('submit_widgetkey', $widget->widget_options->widgetkey)?>
<?if($widget_type == 'Widget\Entities\Types\FormWidgets'):?>
    <?=Form::hidden('tab_type', $widget->widget_options->widgetattr->tab_type, Array('id' => 'selected-tab'))?>
<?endif?>
<span id="update-tabtype-url" hrefaction="<?=URL::to('feedsetup/update_tabtype/')?>"></span>



<div id="theFormSetup" class="dashboard-page">
    <h1>Form Setup</h1>
    <div class="dashboard-box" style="background:#FAFAFA;">
        <div class="dashboard-head">
          <span class="dashboard-title">Form Code Manager</span> <span class="dashboard-subtitle">Select which option suits your needs</span>
        </div>
        <div class="dashboard-body">
            <div class="dashboard-content">
                <div class="form-setup-block">


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
                        </br>
                        <strong>Floating Tab Position : 
                            <select id="tab-position" class="regular-select" style="font-size:12px;padding:5px;">
                                <?php 
                                    preg_match('~tab-(br|bl|tr|tl|r|l)~', $widget->widget_options->widgetattr->tab_type, $match);
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

                        <table width="100%" align="center">
                        <tr><td><strong>JavaScript Version</strong></td></tr>
                        <tr><td><textarea class="dashboard-textarea regular-text highlight" rows="7">
<?=$embed_js_code;?> 
                        </textarea></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent2" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        </br>
                        <table width="100%" align="center">
                        <tr><td><strong>JavaScript Version <small>(Recommended)</small></strong></td></tr>
                        <!--JS Link Pop code goes here-->
                        <tr><td><textarea class="dashboard-textarea regular-text highlight" rows="7">
<?=$embed_js_code;?> 
                        </textarea></td></tr>  
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent3" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        </br>
                        <table width="100%" align="center"> 
                        <tr><td><strong>JavaScript Version <small>(Recommended)</small></strong></td></tr>
                        <tr><td><textarea class="dashboard-textarea regular-text highlight" rows="7">
<?=$link_js_output;?>
                        </textarea></td></tr>
                        <tr><td></br><strong>HTML Popup Version</strong></td></tr>
                        <tr><td><textarea class="dashboard-textarea regular-text highlight" rows="7">
<?=$link_native_output;?>
                        </textarea></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent4" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste Code Snippets to <br />
                        Create a Link to Your Form</h4>
                        </br>
                        <table width="100%" align="center">
                        <tr><td><strong>Permanent Shortlink URL</strong></td></tr>
                        <tr><td><input type="text" class="dashboard-text regular-text highlight" value="<?=$loader_url?>"/></td></tr>
                        <tr height="10"><td></td></tr>
                        <tr><td><strong>Use this HTML Link in a Webpage</strong></td></tr>
                        <tr><td><input type="text" class="dashboard-text regular-text highlight" 
                                       value="<a href='<?=$loader_url?>'>Fill out my form!</a>"/></td></tr>
                        </table>
                    </div>
                  <?else:?>
                    <div id="formcodeboxcontent1" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste this Code into<br />
                        Your Website or Blog Post</h4>
                        
                        <table width="100%" align="center">
                        <tr><td><strong>JavaScript Version <small>(Recommended)</small></strong></td></tr>
                        <!--JS Link Pop code goes here-->
                        <tr><td><textarea class="dashboard-textarea regular-text highlight" rows="7">
<?=$embed_js_code;?> 
                        </textarea></td></tr>  

                        <tr><td><strong>HTML Popup Version</strong></td></tr>
                        <tr><td><textarea class="dashboard-textarea regular-text highlight" rows="7">
<?=$iframe_code;?>
                        </textarea></td></tr>
                        </table>
                        <br />
                    </div>
                    <div id="formcodeboxcontent2" class="formcodeboxcontainer">
                        <h4 style="font-size:16px;line-height:20px;">Copy and Paste Code Snippets to <br />
                        Create a Link to Your Form</h4>
                        </br>
                        <table width="100%" align="center">
                        <tr><td><strong>Permanent Shortlink URL</strong></td></tr>
                        <tr><td><input type="text" class="dashboard-text regular-text highlight" value="<?=$loader_url?>"/></td></tr>
                        <tr height="10"><td></td></tr>
                        <tr><td><strong>Use this HTML Link in a Webpage</strong></td></tr>
                        <tr><td><input type="text" class="dashboard-text regular-text highlight" 
                                       value="<a href='<?=$loader_url?>'>Fill out my form!</a>"/></td></tr>
                        </table>
                    </div>
 
                  <?endif?>
                </div> 
            </div>
        </div>
    </div>
</div></div></div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#tab-position').change(function(){
            var slide = $(this).val();
            $('#tab-slider').children().each(function(){
                $(this).hide();
            });
            
            $('.'+slide+'-design-slide').fadeIn('fast');
        });
        $('#formcodebox ul li').click(function(){
            $(this).parent().find('li.active').removeClass('active');
            display_codes($(this).index() + 1);
            $(this).addClass('active');
        });
        var $form_slide = $('.form-designs').cycle({
            fx:      'scrollHorz', 
            speed:    500, 
            timeout:  0 ,
            pause : 1,
            next:   '.form-design-next', 
            prev:   '.form-design-prev'             
        });
        
        var selected_form = $('#selected-form').val();          //get the selected form
        var current_form_slide = $('#'+selected_form).parent(); //get the parent of the selected form
        var form_index  = parseInt(current_form_slide.index()); //get the index of the parent container
        
        $form_slide.cycle(form_index);                          // cycle the form theme selection to the index number
        $('#'+selected_form).addClass('selected-form');         // add class to the selected form thumbnail
        
        var positions = ['r','l','br','bl','tr','tl'];
        var tabpos = '';        
        
        $tab_slide = [];
        for(pos = 0;pos <= positions.length;pos++){
            tabpos = positions[pos];
            $tab_slide[tabpos] = $('.'+tabpos+'-designs').cycle({
                    fx:      'scrollHorz', 
                    speed:    500, 
                    timeout:  0 ,
                    pause : 1,
                    next:   '.'+tabpos+'-design-next', 
                    prev:   '.'+tabpos+'-design-prev'               
                });
        }
        
        var selected_tab = $('#selected-tab').val();            // get the selected tab
        var current_tab_slide = $('#'+selected_tab).parent();   //show the parent of the selected tab
        var tab_index  = parseInt(current_tab_slide.index());   // get the index of the parent container
        var selected_pos = $('#tab-position').val();            // get the current value of the tab position dropdown box
        
        $tab_slide[selected_pos].cycle(tab_index);              // cycle the current tab design
        
        $('#tab-slider').children().each(function(){            // hide all the tab design positions
            $(this).hide();
        });
        
        $('.'+selected_pos+'-design-slide').show();             // show the selected tab design
        $('#'+selected_tab).addClass('selected-tab');           // add class to the selected tab thumbnail
        
    });
    
    function display_codes(i){
        $('.formcodeboxcontainer').each(function(){
            $(this).hide();
        });
        $('#formcodeboxcontent'+i).fadeIn('fast');
    }
</script>

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