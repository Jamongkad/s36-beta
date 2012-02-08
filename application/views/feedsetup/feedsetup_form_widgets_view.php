<script type="text/javascript">
	$(document).ready(function(){
		$(".large-text").focus(function(i){          		 
				if ($(this).val() == $(this)[0].title){
					$(this).removeClass("reg-text-active");
					$(this).val("");
				}
			});
		$(".large-text").blur(function(){
				if ($.trim($(this).val()) == ""){
					$(this).addClass("reg-text-active");
					$(this).val($(this)[0].title);
				}
			});
		$(".large-text").blur();

        $('.form-designs').cycle({
            fx:      'scrollHorz', 
            speed:    500, 
            timeout:  0 ,
            pause : 1,
            next:   '.form-design-next', 
            prev:   '.form-design-prev'				
        });

        
        var positions = ['r','l','br','bl','tr','tl'];
        var tabpos;
        for(pos = 0;pos <= positions.length;pos++){
            tabpos = positions[pos];
            $('.'+tabpos+'-designs').cycle({
                fx:      'scrollHorz', 
                speed:    500, 
                timeout:  0 ,
                pause : 1,
                next:   '.'+tabpos+'-design-next', 
                prev:   '.'+tabpos+'-design-prev'    
            });
        }
                      	
        $('.br-design-slide, .tr-design-slide, .bl-design-slide, .tl-design-slide, .r-design-slide').hide();
            
        $('#tab-position').change(function(){
            var slide = $(this).val();
            $('#tab-slider').children().each(function(){
                $(this).hide();
            });
            
            $('.'+slide+'-design-slide').show();
        });
        
        var selected_form = $('#selected-form').val();
        var selected_tab = $('#selected-tab').val();
        $('#'+selected_form).addClass('selected-form');
        $('#'+selected_tab).addClass('selected-tab');
        
        $('.form-design').click(function(){
            
            var value = $(this).attr('id');
            
            $('.selected-form').removeClass('selected-form');
            $(this).addClass('selected-form');
            
            $('#selected-form').val(value);
            
        });
        
        $('.tab-design').click(function(){
            var value = $(this).attr('id');
            
            $('.selected-tab').removeClass('selected-tab');
            $(this).addClass('selected-tab');
            
            $('#selected-tab').val(value);
        });
});	
</script>
<?=Form::open('feedsetup/save_form_widget', 'POST', array('id' => 'create-form-widget'))?>
<?$site_id = Input::get('site_id')?>
<?=Form::hidden('site_id', $site_id)?>
<?=Form::hidden('company_id', $company_id)?>
<div class="block">
    <div id="widget-setup-block">
        <div class="widget-options">
            <h2><span>Step 1 :</span> Choose a name for your form and a question to encourage your users</h2>
            <!-- selected form and color -->
                <input type="hidden" name="theme_type" value="form-black" id="selected-form" />
                <input type="hidden" name="tab_type" value="tab-l-black" id="selected-tab" />
            <!-- end -->
            <div class="widget-types">
                    <table width="100%" cellpadding="5" cellspacing="0">
                        <tr>
                            <td width="120">
                                <strong style="font-size:14px;">Form Name :</strong>
                            </td>
                            <td><input type="text" class="large-text" name="theme_name" value="" title="Name your form" /></td>
                        </tr>
                        <tr>
                            <td>
                                <strong style="font-size:14px;">Form Title :</strong>
                            </td>
                            <td><input type="text" class="large-text" name="form_text" value="" title="ex. Give us your feedback" /></td>
                        </tr>
                    </table>
            </div>
        </div>
        <div class="widget-options">
            <h2><span>Step 2 :</span> Choose your website you want to apply your Widget to</h2>
            <div style="padding:10px">
                <select name="site_id" id="feedsetup-site-select" class="regular-select" hrefaction="<?=URL::to('feedsetup/render_display_info')?>" style="font-size:15px"> 

                    <?foreach($site as $sites):?>
                        <option value="<?=$sites->siteid?>" <?=(Input::get('site_id') == $sites->siteid) ? 'selected' : null?>><?=$sites->domain?></option>
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
                <?php  
                    $colors = array('black'=>'Black',
                                    'gray'=>'Silver Gray',
                                    'blue'=>'Ocean Blue',
                                    'green'=>'Forest Green',
                                    'yellow'=>'Mandarin',
                                    'orange'=>'Sleek Orange',
                                    'red'=>'Thin Red'
                                   );                                         
                ?>
                    <div class="form-design-slide">
                        <div class="form-design-prev">
                        </div>
                        <div class="form-designs grids">
                            <div class="form-design-group grids">
                                <?php
                                    $form_slides = '';
                                    foreach($colors as $form_colors => $val){
                                        $form_slides .= '<div class="form-design" id="form-'.$form_colors.'">
                                                            <img src="/img/tab-designs/'.$form_colors.'-form.png" height="60" />
                                                            <br />
                                                            <span>'.$val.'</span>
                                                        </div>';
                                    }
                                    echo $form_slides;
                                ?>
                            </div>
                        </div>
                        <div class="form-design-next">
                        </div>
                    </div>
                </div>
                <br />
                <strong style="font-size:14px;">Floating Tab Position : <select id="tab-position" class="regular-select" style="font-size:12px;padding:5px;">
                                                                            <option value="l">Left Side Tab</option>
                                                                            <option value="r">Right Side Tab</option>
                                                                            <option value="tr">Top Right Corner</option>
                                                                            <option value="tl">Top Left Corner</option>
                                                                            <option value="br">Bottom Right Corner</option>
                                                                            <option value="bl">Bottom Left Corner</option>
                                                                        </select></strong>
                <div class="widget-info" style="margin:0px -20px;"></div>
                <br />
                <strong style="font-size:14px;">Tab Design : </strong>
                <div id="tab-slider" class="widget-info" style="margin:0px -20px;">
                
                <?php
                    
                    $positions  = array('r','l','br','bl','tr','tl');
                    
                    $slider = '';
                    foreach ($positions as $pos) {
                        $slider .= '<div class="'.$pos.'-design-slide">
                                      <div class="'.$pos.'-design-prev">
                                      </div>
                                      <div class="'.$pos.'-designs grids">
                                      <div class="form-design-group grids">';
                                        foreach($colors as $key => $val){
                                            $slider .= '<div class="tab-design" id="tab-'.$pos.'-'.$key.'">
                                                            <img src="/img/tab-designs/'.$pos.'-'.$key.'-tab-design.png" height="60" />
                                                            <br />
                                                            <span>'.$val.'</span>
                                                        </div>';
                                        }
                                    $slider .= '</div>
                                            </div>
                                        <div class="'.$pos.'-design-next">
                                        </div>
                                    </div>';                 
                    }
                    echo $slider;	
                ?>
                </div>
            </div>
        </div>
        <div class="widget-options">
            <div class="block noborder" style="margin-left:-10px;">
            <!--
            <a href="#" class="button">Save Form</a> &nbsp;&nbsp; <a href="#" class="button-gray">Preview Form</a>
            -->
            <input type="submit" class="large-btn create-widget-button" value="Save & Preview Your Submission Form" />
            </div>
        </div>
    </div>
</div>
<?=Form::close()?>
<!-- spacer -->
<div class="block noborder" style="height:300px;">
</div>
<!-- spacer -->
</div>

<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
</div>
