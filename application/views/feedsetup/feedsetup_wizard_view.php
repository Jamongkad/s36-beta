<?=Form::open('feedsetup/save_display_widget', 'POST', Array('id' => 'create-widget'))?>
<?=Form::hidden('widget_type', 'display')?>
<?=Form::hidden('site_id', $site[0]->siteid)?>
<?=Form::hidden('company_id', $company_id)?>
<?=Form::hidden('display_widgetkey', false)?>
<?=Form::hidden('submit_widgetkey', false)?>
<?=Form::hidden('theme_type', 'form-aglow', Array('id' => 'selected-form'))?>
<?=Form::hidden('perms[feedbacksetupdisplay][displayname]', 1);?>
<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <h3>CUSTOMIZE YOUR EMBEDDED DISPLAYS</h3>
</div>
<br />
<div class="block noborder">
    <div id="wizard">
        <div id="wizard-step-1" class="wizard-steps current">
            <span><strong>Step 1 </strong><span class="blue">Feedback Display Option</span></span>
            <br /><br />
            <span>Name and save as : </span>
            <div class="grids">
                <div class="g3of4">
                    <input type="text" id="form-name" class="wizard-text-field" name="theme_name" value="" title="Name of your widget" />
                    <div class="grids">
                        <div class="g1of3" style="height:200px">
                            <img src="/img/embed-feedback-3.png" />
                        </div>
                        <div class="g2of3">
                            <br />
                            <span class="blue"><strong>Selected</strong> : Embedded Display </span>
                            <br />
                            <small class="underline"><?=HTML::link('feedsetup/widget_selection', 'change')?></small>
                        </div>
                    </div>
                </div>
                <div class="g1of4">
                    &nbsp;
                </div>
            </div>
        </div>
        <div id="wizard-step-2" class="wizard-steps">
            <span><strong>Step 2 </strong><span class="blue">Feedback Display Option</span></span>
            <br /><br />
            <span>Your header text : </span>
            <div class="grids">
                <div class="g3of4">
                    <input type="text" id="header-text" class="wizard-text-field" name="form_text" style="padding:8px;"  
                           title="What our customers have to say" />
                </div>
                <div class="g1of4">
                    &nbsp;
                </div>
            </div>
            <div class="grids" style="height:185px">
                <img src="/img/embedded-display-preview.jpg" />
            </div>
        </div>
        <div id="wizard-step-3" class="wizard-steps">
            <span><strong>Step 3 </strong><span class="blue">Customize your feedback display effects and layout</span></span>
            <br /><br />
            <span>Transition Effect : </span>
            <div class="grids">
                <div class="g1of4">
                    <select name="embed_effects" class="wizard-select"> 
                        <?foreach($effects_options as $rows):?>        
                            <option value="<?=$rows->effectsid?>"><?=$rows->effectsname?></option>
                        <?endforeach?> 
                    </select>
                </div>
                <div class="g3of4">
                    &nbsp;
                </div>
            </div>
            <div class="grids">
                <div class="g1of4" style="height:250px">
                    <input type="radio" name="embed_block_type" value="embed_block_x" id="horizontal_embed" /> Horizontal
                    <br />
                    <img src="/img/preview-horizontal-embed.png" />
                </div>
                <div class="g1of4" style="height:250px">
                    <input type="radio" name="embed_block_type" value="embed_block_y" id="vertical_embed" /> Vertical
                    <br />
                    <img src="/img/preview-horizontal-embed.png" />
                </div>
            </div>
            <br />
            <span>Choose your theme : </span>
            <br />
            <input type="hidden" val="" id="selected-form" name="form-design" />
            <div class="form-design-slide" style="margin-left:-10px;">
                <div class="form-design-prev">
                </div>
                    <div class="form-designs grids">  
                    <?php
                        $form_slides = '';
                        $units = 7;
                        $ctr = 0;
                        $max = count($form_themes);
                        
                        foreach($form_themes as $form_colors => $val){
                            if (($ctr % $units) == 0) {
                                $form_slides .= '<div class="form-design-group grids">';
                                $end = 1;
                            }

                                $color_name = 'form-'.$form_colors;
                                $form_slides .= '<div class="form-design" id="'.$color_name.'">
                                                    <img src="/img/display-thumb.png "/>
                                                    <span>'.$val.'</span>
                                                    <!--
                                                    <div id="preview" class="preview button-gray">
                                                        Preview
                                                    </div>
                                                    -->
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
        <div id="wizard-step-4" class="wizard-steps">
            <span><strong>Step 4 </strong><span class="blue">Feedback detail display options </span></span>
            <br /><br />
            <span>Customize the fields you want to show up in your template. <br />
                  Uncheck items you want to hide (example - Country). </span>
            <div class="grids">
                <div class="g1of2">
                <br />
                    <div class="grids wizard-display-options">
                        <p><label>Display Image :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displayimg]', 1, 1, Array(  'class' => 'display-option'
                                                                                                 , 'id' => 'preview-avatar'))?>
                        </p>
                        <p><label>Company Name :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaycompany]', 1, 1, Array(  'class' => 'display-option'
                                                                                                     , 'id' => 'preview-company'))?>
                        </p>
                        <p><label>Designation / Position :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displayposition]', 1, 1, Array(  'class' => 'display-option'
                                                                                                      , 'id' => 'preview-position'))?>
                        </p>
                        <p><label>Website Url :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displayurl]', 1, 1, Array(  'class' => 'display-option'
                                                                                                 , 'id' => 'preview-website'))?>
                        </p>
                        <p><label>Country & Flag : </label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaycountry]', 1, 1, Array(  'class' => 'display-option'
                                                                                                     , 'id' => 'preview-author-location'))?>
                        </p>
                        <p><label>Submitted Date :</label> 
                        <?=Form::checkbox('perms[feedbacksetupdisplay][displaysbmtdate]', 1, 1, Array(  'class' => 'display-option'
                                                                                                      , 'id' => 'preview-feedback-date'))?>
                        </p>
                    </div>
                </div>
                <div class="g1of2">
                    <div class="align-center widget-preview-text">PREVIEW DISPLAY</div>
                    <div class="wizard-feedback-preview">
                        <div id="wizard-preview-box">
                            <div id="wizard-preview-author-info"> 
                                <div id="wizard-preview-avatar"><img id="avatar-display" src="/img/48x48-blank-avatar.jpg" /><img id="avatar-blank" src="/img/48x48-blank-avatar.jpg" style="display:none;"/></div>
                                <div id="wizard-preview-author-details">
                                    <div id="wizard-preview-author-name">Nelson Cardella</div>
                                    <div id="wizard-preview-author-position"><span id="wizard-preview-position">Marketing Manager,</span> <span id="wizard-preview-company"><a href="javascript:;" id="wizard-preview-website">Davis LLP</a></span></div>
                                    <div id="wizard-preview-author-location">Manitoba City, Canada <span class="flag flag-cn"></span></div>
                                </div>
                            </div>
                            <div id="wizard-preview-feedback-text">
                                I had great time using your product. It was even better than I expected. Will definitely come back again to try your next few dishes out... seriously fantastic.. (<a href="#" class="read-full">read full feedback</a>)
                            </div>
                            <div id="wizard-preview-feedback-date">
                                13th Sept. 2011
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="wizard-step-5" class="wizard-steps">
            <span><strong>Step 5 </strong><span class="blue">Feedback Form Options </span></span>
            <div class="grids" style="overflow:visible;">
                <div class="g1of2">
                    <br />
            <span>Customize the feedback form that your customers<br />and visitors see when they click 'Send Feedback' from your<br />display widget.</span>
                    <br /><br />
                    Form Header Text :
                    <br />
                    <input type="text" id="form-header-text" class="wizard-text-field" name="submit_form_text" value="" title="Give us your feedback" />
                    <br />
                    What to write?
                    <br />
                    <textarea id="form-what-to-write" name="submit_form_question" class="wizard-text-field" rows="6" title="What do you like about our products?">
                    </textarea>
                    <small>Questions to help your customers/visitors respond to your form in a certain way. This text will appear if they click "What to write?".</small>
                    <br />
                    <br />
                    <br />
                    <br />
                </div>
                <div class="g1of2">
                    <img src="/img/form-preview.jpg" style="margin-top:-20px;margin-left:-20px;"/>
                </div>
            </div>
        </div>
        <div id="wizard-step-6" class="wizard-steps">
            <span class="blue">Forwarding to our integration menu now…</span>
        </div>
    </div>
    <div id="wizard-error-prompt">
        
    </div>
    <div class="wizard-buttons">
        <a href="javascript:;" class="wizard-btn" id="wizard-back">Back</a>
        &nbsp;
        <a href="javascript:;" class="wizard-btn" id="wizard-next">Next</a>
    </div>
</div>
<div class="block noborder" style="height:150px;">
</div>
<?=Form::close()?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.display-option').click(function(){
            run_display_option();
        });
        /* added for wizard page */
        var $wizard_slide = $('#wizard').cycle({
            fx:      'fade', 
            speed:    200, 
            timeout:  0 ,
            pause : 1,
            before: adjust_height
        });
        $(".wizard-textarea, .wizard-text-field").focus(function(i){          		 
            if ($(this).val() == $(this)[0].title){
                $(this).removeClass("reg-text-active");
                $(this).val("");
            }
        });
        $(".wizard-textarea, .wizard-text-field").blur(function(){
                if ($.trim($(this).val()) == ""){
                    $(this).addClass("reg-text-active");
                    $(this).val($(this)[0].title);
                }
            });
        $(".wizard-textarea, .wizard-text-field").blur();
        /* end */
        
        check_current_wizard_step();
        
        $('#wizard-back').hide();
        
        $('#wizard-next').click(function(){
            cur_step = check_current_wizard_step();
            console.log(cur_step);
            if(cur_step == 'wizard-step-1'){
                var form_name = $('#form-name');
                if(!validate_field(form_name.attr('id'),form_name.val(),form_name.attr('title'), "regular")){
                    form_name.focus();
                    console.log('Please Enter Your First Name');
                }else{
                    $wizard_slide.cycle('next');
                    $('#wizard-back').fadeIn();
                }
            }else if(cur_step == 'wizard-step-2'){
                var header_text = $('#header-text');
                if(!validate_field(header_text.attr('id'),header_text.val(),header_text.attr('title'), "regular")){
                    header_text.focus();
                    console.log('Please Enter Header Text');
                }else{
                    $wizard_slide.cycle('next');
                }
            }else if(cur_step == 'wizard-step-5'){
                var form_header_text = $('#form-header-text');
                var form_what_to_write =  $('#form-what-to-write');
                
                if(!validate_field(form_header_text.attr('id'),form_header_text.val(),form_header_text.attr('title'), "regular")){
                    form_header_text.focus();
                    console.log('Please Enter Form Header Text');
                }else if(!validate_field(form_what_to_write.attr('id'),form_what_to_write.val(),form_what_to_write.attr('title'), "regular")){
                    form_what_to_write.focus();
                    console.log('Please Enter What to Write Text');
                }else{
                    $wizard_slide.cycle('next');
                    $('#wizard-next').fadeOut('fast');
                    $('#wizard-back').fadeOut('fast');
                    console.log('FINISHED');
                    $.ajaxForm({
                        success: function(msg) {
                            console.log(msg);
                        }
                    })
                }
            }else{
                $wizard_slide.cycle('next');
            }
        });
        
        $('#wizard-back').click(function(){
            cur_step = check_current_wizard_step();
            if(cur_step == 'wizard-step-2'){
                $(this).fadeOut();
            }
            $wizard_slide.cycle('prev');
        });
        
        $('.form-design').click(function(){
            var value = $(this).attr('id');
            $('.selected-form').removeClass('selected-form');
            $(this).addClass('selected-form');
            $('#selected-form').val(value);
        });
        
    });
    
    function check_current_wizard_step(){
        var cur_step = $('#wizard').find('.current').attr('id');
        if(cur_step != 'wizard-step-1'){
            $('#wizard-back').fadeIn();		
        }else{
            $('#wizard-back').fadeOut();
        }
        return cur_step;
    }
    
    function adjust_height(curr, next, opts, fwd) {		
        var index = opts.currSlide;
        var $ht = $(this).height();
        $(this).parent().animate({height: $ht},200);				
        $(this).parent().find('div.current').removeClass('current'); 
        $(this).addClass('current');
    }
    
    function run_display_option(){
        var display_id = '';
        $('.display-option').each(function(){
            display_id = $(this).attr('id');
            container_id = "#wizard-"+display_id;
            if($(this).attr('checked')){							
                if($(this).attr('id') == 'preview-avatar'){
                    $('img#avatar-display').fadeIn();
                    $('img#avatar-blank').hide();
                }else if($(this).attr('id') == 'preview-website'){
                    $(container_id).css('text-decoration','underline');
                }else{
                    $(container_id).fadeIn('fast');
                }
            }else{
                
                if($(this).attr('id') == 'preview-avatar'){
                    $('img#avatar-display').hide();
                    $('img#avatar-blank').fadeIn();
                }else if($(this).attr('id') == 'preview-website'){
                    $(container_id).css('text-decoration','none');
                }else{
                    $(container_id).fadeOut('fast');
                }						
            }
        });
    }
    function validate_field(fieldid,value,default_val,type){
        if(type == "regular"){   // check if type is only regular
            if((value.length <= 0) || (value == default_val)){		
                return false;
            }else{
                return true;
            }
        }else if(type == "email"){ //if type is email
            if((value.length <= 0) || (value == default_val)){
                return false;
            }else if(!validate_email(value)){
                return false;	
            }else{
                return true;
            }
        }else if(type == "phone"){
            //phone only allows '+',','," " and numeric values 
            var phone = new RegExp('[+0-9 ,]');
            var notallow = new RegExp('[a-zA-Z]');
            if((!value.match(phone)) || (value.match(notallow))){
                return false;
            }else{
                return true;
            }
        }else if(type == "numeric"){
            //strictly allows numeric values only
            var numeric = new RegExp('[0-9 ]');
            var notallow = new RegExp('[a-zA-Z]');
            if((!value.match(numeric)) || (value.match(notallow))){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    function validate_email(email) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        return true;
        }else{
        return false;
        }
    }
</script>
