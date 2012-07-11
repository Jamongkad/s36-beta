<?=Form::open('feedsetup/update_hosted_settings', 'POST', Array('id' => 'update-hosted'))?>
<?=Form::hidden('companyId', $company_id)?>
<?=Form::hidden('theme_type', 'matte', Array('id' => 'selected-form'))?>
<div>
    <div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
        <h3>HOSTED FEEDBACK DISPLAY SETUP</h3>
    </div>
    <div class="block noborder">
        <div id="hosted-wizard">
            <div id="hosted-wizard-step-1" class="wizard-steps current">
                <h2 class="large-black">Step 1 Choose a design theme from the follow categories:</h2>
                <br />                
                <div class="grids">
                    <div class="">
                        <select class="regular-select" id="theme-select">
                            <?foreach($main_themes as $main_theme):?>
                                <option value="<?=$main_theme?>"><?=ucwords($main_theme)?></option>
                            <?endforeach?>
                        </select>
                        <!--<input type="hidden" value="1" id="selected-theme" name="selected-theme" />-->
                        <!--<a href="#">View all Categories</a>-->
                        <div class="grids">
                        <br />
                            <div id="corporate" class="form-design-slide" style="margin-left:-10px;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->corporate->children, 'data_type' => null))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                            <div id="minimalist" class="form-design-slide" style="margin-left:-10px;display:none;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >                                                               
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->minimalist->children, 'data_type' => null))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                            <div id="creative" class="form-design-slide" style="margin-left:-10px;display:none;">
                                <div class="form-design-prev" style="margin-top:15px;">
                                </div>
                                <div class="form-designs grids" >                                                                   
                                    <?=View::make('feedsetup/partials/feedsetup_hostedthemes_picker_view', 
                                           array('themes'=> $themes->creative->children, 'data_type' => null))?>
                                </div>
                                <div class="form-design-next" style="margin-top:15px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div id="hosted-wizard-step-2" class="wizard-steps">
                <h2 class="large-black">Configure your hosted page to suit your website and theme - you can direct visitors to your hosted page to view existing published feedback, or to get them to send in feedback.</h2>
                <br />
                <div class="grids">
                    <div class="g3of4">
                        <span>Configure your feedback header text</span>
                        <input type="text" name="header_text" id="header-text" class="wizard-text-field" 
                               title="Hear what our customers have to say" />
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
                <div class="grids" style="height:285px">
                    <img src="/img/hosted-display-preview.jpg" />
                </div>
            </div>
            <div id="hosted-wizard-step-3" class="wizard-steps">
                <h2 class="large-black">Configure your feedback submission form to encourage your users to leave feedback about company/service/product</h2>
                <br />
                <div class="grids">
                    <div class="g3of4">
                        <span>Customize your submission form header title</span>
                        <input type="text" name="submit_form_text" id="header-title-text" class="wizard-text-field" title="Header Title" />
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
                <div class="grids" style="height:314px">
                    <img src="/img/hosted-form-preview.jpg" />
                </div>
                <div class="grids">
                    <h2 class="large-black">Configure your feedback prompt to encourage users to say something specific about your brand, product or service.</h2>
                    <br />
                    <div class="g3of4">
                        <span>Customize your submission form feedback prompt:</span>
                        <textarea id="form-what-to-write" name="submit_form_question" class="wizard-text-field" rows="6" title="What do you like about our products?"></textarea>
                    </div>
                    <div class="g1of4">
                        &nbsp;
                    </div>
                </div>
            </div>                     
        </div>
        <div id="wizard-error-prompt"></div>
        <div class="wizard-buttons">
            <a href="javascript:;" class="wizard-btn" id="hosted-wizard-back">Back</a>
            &nbsp;
            <a href="javascript:;" class="wizard-btn" id="hosted-wizard-next">Next</a>
            <input type="submit" class="large-btn create-widget-button" value="save widget" style="display:none" / >
        </div>
    </div>
    <div class="block noborder" style="height:150px;">
        
    </div>
</div>

<!-- end of the main panel -->

<!-- div need to clear floated divs -->
<div class="c"></div>
<?=Form::close()?>
<style type="text/css">
    /* submission widget */
    input.large-text{padding:10px;width:80%;}
    .form-design-slide,
    .l-design-slide,
    .r-design-slide,
    .tr-design-slide,
    .tl-design-slide,
    .br-design-slide,
    .bl-design-slide
    {width:656px;height:110px;padding:0px 10px;}
    
    .form-design-prev{
        float:left;
        width:25px;
        height:80px;
        cursor:pointer;
        background:url(/img/btn-prev.png) no-repeat center center;
    }
    
    .form-design-next{
        float:right;
        width:25px;
        height:80px;
        background:url(/img/btn-next.png) no-repeat center center;
        cursor:pointer;
    }
    .l-design-prev,.r-design-prev,.br-design-prev,.bl-design-prev,.tr-design-prev,.tl-design-prev{
        float:left;
        width:25px;
        height:80px;
        cursor:pointer;
        background:url(/img/btn-prev.png) no-repeat center center;
    }
    .l-design-next,.r-design-next,.br-design-next,.bl-design-next,.tr-design-next,.tl-design-next{
        float:right;
        width:25px;
        height:80px;
        background:url(/img/btn-next.png) no-repeat center center;
        cursor:pointer; 
    }
    .form-designs,.l-designs,.r-designs,.br-designs,.bl-designs,.tr-designs,.tl-designs{
        width:606px;
        float:left;
        height:120px;
    }
    .form-design-group{
        width:586px;
        margin:5px 10px;
        height:110px;
    }
    .form-design{
        width:105px;
        float:left;
        text-align:center;
        padding:10px 0px;
        border:1px solid #fff;
        margin:0px 5px;
        background:#e9e9e9;
    }
    .tab-design{
        width:81px;
        float:left;
        text-align:center;
        padding:5px 0px;
        border:1px solid #f4f4f4;
    }
    .form-design img,.tab-design img{
        margin:0px !important;
    }
    .form-design span,.tab-design span{
        color:#487ba8;
        font-size:11px;
    }
    .form-design:hover,.tab-design:hover{
        background:#CCC;
        cursor:pointer;
        background:#ffffff;
        border:1px solid #d1d1d1;
        -webkit-border-radius:2px;
        -moz-border-radius:2px;
        border-radius:2px;
    }
    .selected-form,.selected-tab{
        background:#CCC;
        cursor:pointer;
        background:#e1f8ff;
        border:1px solid #d1d1d1;
        -webkit-border-radius:2px;
        -moz-border-radius:2px;
        border-radius:2px;
    }
    .regular-textarea{
        display: block;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
        border: 1px solid #CCC;
        margin: 5px 5px;
        padding: 4px;
        font-size: 11px;
        color: #777;}
    a.button-gray{
    background:#eceff1 url(/img/button-highlight.png) top repeat-x;
    color:#6b8194;
    padding:4px 11px;
    text-decoration:none !important;
    -webkit-border-radius:12px;
    -moz-border-radius:12px;
    border-radius:12px;
    border:1px solid #c1c8d0;
    font-weight:bold;
}
a.button-gray:hover{background:#dce9f5;}

/* new classes for classses! */
.the-selected-widget-box{
    width:194px;
    height:284px;
    border:#d6dfe6 1px solid;
    position:absolute;
    background:#ebf0f4;
    right:0px;
    top:-10px;
    padding:8px;
    text-align:center;
    z-index:10;
}
.the-selected-widget-box img{margin:0 !important;}

.blue{color:#447697;}
#wizard{}
.wizard-text-field,.wizard-select{
    width: 85%;
    display: block;
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    border-radius: 6px;
    border: 1px solid #CCC;
    margin: 10px 0px;
    padding: 8px 8px;
    font-size: 11px;
    color: #777;	
    font-family:Arial;
}
.underline{text-decoration:underline}
.wizard-steps{width:666px;}
.wizard-buttons{padding-bottom:20px;margin-top:20px;}
.wizard-btn{background:#8e9caa;
    color:#FFF;font-weight:bold;-webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    padding:6px 10px;font-size:14px;
}
.wizard-btn:hover{background-color:#4c7095}
.wizard-btn:active{background-color:#305579;}

.wizard-display-options{font-size:12px;margin-top:15px;}
.wizard-display-options p{margin:2px 0px;}
.wizard-display-options p:after,#wizard-preview-author-info:after{display:block;visibility:hidden;content:".";height:0;clear: both}
.wizard-display-options label{width:180px;float:left;}
.wizard-display-options input{width:20px;float:left;margin:2px 0px 0px 0px;}
.wizard-feedback-preview{
    display:block;
    background:#EEE;
    padding:5px;
    margin:0 auto;
    margin-top:10px;
    width:250px;
}
#wizard-preview-box{
    background:#FFF;
    padding:15px;
}
.widget-preview-text{width:260px;color:#4b7ca0;font-size:14px;margin:0 auto;}
#wizard-preview-avatar img{padding:0px !important;margin:0px !important;}
#wizard-preview-avatar{float:left;width:48px;}	
#wizard-preview-author-details{margin-left:60px;}
#wizard-preview-author-name{font-weight:bold;}
#wizard-preview-author-position{font-size:11px;}
#wizard-preview-author-location{font-size:10px;}
#wizard-preview-author-position span a{color:#b8b3ba;text-decoration:underline;}
#wizard-preview-feedback-date{text-align:right;color:#b8b3ba;font-size:11px;}
#wizard-preview-feedback-text{padding:10px 0px;}
#wizard-preview-feedback-text .read-full{font-size:10px;color:#86bde4}
.large-black{font-size:14px;color:#2f2f2f;}
</style>

<script type="text/javascript">
    jQuery(function($) { 

        var hosted_wizard_slide = $('#hosted-wizard').cycle({
            fx:      'fade', 
            speed:    200, 
            timeout:  0 ,
            pause : 1,
            before: adjust_height
        });

        $('#hosted-wizard-back').hide();

        $('#hosted-wizard-next').click(function(e){
            var cur_step = check_current_hosted_wizard_step(); 
            $('#hosted-wizard-back').fadeIn();		
            
            if(cur_step == 'hosted-wizard-step-1'){
                hosted_wizard_slide.cycle('next');
                $('#hosted-wizard-back').fadeIn();
            }

            if(cur_step == 'hosted-wizard-step-2'){
                $('#hosted-wizard-next').fadeOut('fast');
                $('.create-widget-button').fadeIn('fast'); 
                hosted_wizard_slide.cycle('next');
            }
        });

        $('#hosted-wizard-back').click(function(){
            var cur_step = check_current_hosted_wizard_step();

            if(cur_step == 'hosted-wizard-step-2'){
                $(this).fadeOut();
            } else {
                $('#hosted-wizard-next').fadeIn('fast');     
                $('.create-widget-button').hide(); 
            }

            hosted_wizard_slide.cycle('prev');
        });

        function adjust_height(curr, next, opts, fwd) {		
            var index = opts.currSlide;
            var $ht = $(this).height();
            $(this).parent().animate({height: $ht},200);				
            $(this).parent().find('div.current').removeClass('current'); 
            $(this).addClass('current');
        }

        function check_current_hosted_wizard_step(){
            var cur_step = $('#hosted-wizard').find('.current').attr('id');
            return cur_step;
        }
    })
</script>
