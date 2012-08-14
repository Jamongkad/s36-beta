<?=Form::open('feedback/addfeedback')?>
<input type="hidden" value="<?=$company_id?>" name="company_id" />
<input type="hidden" id="cropped_photo" name="cropped_image_nm" value="0" />
<input type="hidden" name="login_type" value="36" />
<input type="hidden" name="profile_link" value="">
<input type="hidden" name="orig_image_dir" value="/img/blank-avatar.png" />

<div class="block">
    <div id="add-feedback-setup-block">
        <div class="add-feedback-options">
            <h2>Add Feedback</h2>
            <div class="add-feedback-types">
                <h3><label for="full_page_type">Recepient Details</label></h3>
                <div class="add-feedback-form" id="full_page_add-feedback">    
                    <div class="grids">
                        <div class="rate-text"><label><strong>Rating :</strong></label> </div>
                        <div class="rate">
                            <div class="rate-slider" id="smart-slider">
                                <input type="hidden" id="rating" name="rating" value="3" >
                                <div id="track_ball"></div>
                                <div id="rate_b"></div>
                                <div id="rate_p"></div>
                                <div id="rate_a"></div>
                                <div id="rate_g"></div>
                                <div id="rate_e"></div>
                            </div>
                            <div class="ratings">
                                <ul>
                                    <li class="bad">BAD</li>
                                    <li class="poor">POOR</li>
                                    <li class="average">AVERAGE</li> 
                                    <li class="good">GOOD</li>
                                    <li class="excellent">EXCELLENT</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="grids">
                        <label><strong>Feedback : </strong></label><br />
                        <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('feedback')."</p>" : null?>
                        <textarea class="regular-text" id="feedback" name="feedback" style="width:400px;float:left" rows="7">
<?=$input['feedback']?></textarea>
                    </div>
                    <br />
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>Site :</strong></label>
                            <select name="site_id">
                                <?foreach($sites as $site):?>
                                    <option value="<?=$site->siteid?>"><?=$site->domain?></option>
                                <?endforeach?>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="grids">
                        <label><strong>Display Options :</strong></label> 
                        <input type="radio" checked="checked" name="permission" value="1" id="permission1"/> <label for="permission1" >Full Permission</label> 
                        <input type="radio" name="permission" value="2" id="permission2" /> <label for="permission2" >Limited Permission </label>
                        <input type="radio" name="permission" value="3" id="permission3" /> <label for="permission3" >Private</label>
                    </div>
                    <br />
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>First Name</strong></label><br />
                            <input type="text" name="first_name" value="<?=$input['first_name']?>" class="regular-text" id="firstname" />
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('first_name')."</p>" : null?>
                        </div>
                        <div class="g1of3">
                            <label><strong>Last Name</strong></label><br />
                            <input type="text" name="last_name" value="<?=$input['last_name']?>" class="regular-text" id="lastname" />
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('last_name')."</p>" : null?>
                        </div>
                        <div class="g1of3">&nbsp;</div>
                    </div>
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>Email Address</strong></label><br />
                            <input type="text" name="email" value="<?=$input['email']?>" class="regular-text" id="email" />
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('email')."</p>" : null?>
                        </div>
                        <div class="g1of3">
                            <label><strong>Website</strong></label><br />
                            <input type="text" name="website" class="regular-text" id="website" />
                        </div>
                        <div class="g1of3">&nbsp;</div>
                    </div>
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>City</strong></label><br />
                            <input type="text" name="city" value="<?=$input['city']?>" class="regular-text" id="city" />
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('city')."</p>" : null?>
                        </div>
                        <div class="g1of3">

                            <label><strong>Country</strong></label><br />
                            <select class="regular-select" name="country" id="country"> 
                                <option value="">Not Applicable</option>
                                <?foreach($countries as $country):?>
                                    <option value="<?=$country->code?>"><?=$country->name?></option>
                                <?endforeach?>
                            </select>
                            <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('country')."</p>" : null?>
                        </div>
                        <div class="g1of3">&nbsp;</div>
                    </div>
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>Company</strong></label><br />
                            <input type="text" name="company" class="regular-text" id="company" />
                        </div>
                        <div class="g1of3">
                            <label><strong>Position</strong></label><br />
                            <input type="text" name="position" class="regular-text" id="position" />
                        </div>
                        <div class="g1of3">&nbsp;</div>
                    </div>
                    <div class="grids">
                        <div class="g1of3">
                            <label><strong>Preview :</strong></label><br />
                            <div>
                                <?=HTML::image('img/blank-avatar.png', false, 
                                    array( 'id' => 'profile_picture'
                                         , 'style' => ' border:2px solid #CCC;'
                                         , 'width' => 97))?>
                            </div>
                        </div>
                        <div class="g1of3">
                            <span id="ajax-upload-url" hrefaction="<?=URL::to('/widget/form/upload')?>"></span>
                            <span id="ajax-crop-url" hrefaction="<?=URL::to('/widget/form/crop')?>"></span>
                            <label><strong>Add Photo :</strong> </label> <br />
                            <div style="padding-left:10px;font-weight:bold;">
                                <div style="margin:5px 0px;">
                                    <input type="file" 
                                           id="your_photo" 
                                           class="fileupload" 
                                           name="your_photo" 
                                           data-url="<?=URL::to('/widget/form/upload')?>"/> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grids adjust-crop">
                        <div class="g1of3">
                            <label><strong>Adjust and crop your image</strong></label><br/>

                            <div>
                                <div style="padding:15px 0px;">
                                    <div class="jcrop_div">
                                        <?=HTML::image('img/blank-avatar.png', 'Profile Picture', array('id' => 'jcrop_target'))?>
                                    </div>
                                </div>
                                <div style="width:100px;text-align:center;font-size:10px;color:#CCC;float:left;">
                                    <div style="margin-bottom:5px">Preview</div>
                                    <div style="width:100px;height:100px;overflow:hidden;">
                                           <?=HTML::image('img/blank-avatar.png', false, array('id' => 'preview'))?>
                                    </div>
                                </div>
                                <div style="width:200px;float:left;margin-left:10px;">
                                    <div id="test_showcoords"></div>
                                    <span id="crop_status"></span>
                                    <form>
                                        <input type="hidden" id="x" name="x" />
                                        <input type="hidden" id="y" name="y" />
                                        <input type="hidden" id="w" name="w" />
                                        <input type="hidden" id="h" name="h" />
                                    </form>
                                </div>

                                <div style="height:100px"></div> 
                                <input type="button" value="crop" class="large-btn" id="cropbtn"/>
                            </div>   
                        </div>
                    </div>
                </div>
                <div class="error-message"> </div>
            </div> 
        </div> 
        <div class="add-feedback-setup-border"></div> 
        <div style="padding-left:10px">
            <br />
            <input type="submit" class="large-btn" value="add feedback" />
            <br /><br />
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

<script type="text/javascript">
jQuery(function($){
    start_slider();
    $('.error-message').hide();
    $('#add_feedback').click(function(){
        add_feedback();
    });
             
});

function start_slider(){
	$('#rate_b').click(function(){ slide_track_to('-3px'  , 1); });
	$('#rate_p').click(function(){ slide_track_to('+119px', 2); });
	$('#rate_a').click(function(){ slide_track_to('+244px', 3); });
	$('#rate_g').click(function(){ slide_track_to('+369px', 4); });
	$('#rate_e').click(function(){ slide_track_to('+492px', 5); });
}

function slide_track_to(y,rating){
	$('#track_ball').animate({'left':y});
	$('#rating').val(rating);
}
</script>

<style type="text/css">
    #add-feedback-setup-block{
        background:#f4f4f4;	
        margin-left:-10px;
    }
    .add-feedback-setup-border{display:block;height:2px;background:url(/img/false-border.png);}
    .add-feedback-options{
        padding-bottom:10px;
    }
    .add-feedback-options h2{
        background:#6b7984;
        color:#dedede;
        font-size:14px;
        display:block;
        padding:4px 8px;
        border:1px solid #626f79;
    }
        .add-feedback-types{
            padding:10px 20px 0px;
        }
        .add-feedback-types h3{
            cursor:pointer !important;
            font-size:14px !important;
            color:#778086 !important; 
            display:block;
            padding-bottom:10px;
            margin:0px !important;
            background:url(/img/false-border.png) repeat-x bottom;
        }
        .add-feedback-types h3 label{cursor:pointer;}
        .add-feedback-opts{
            padding:5px 10px;
        }
        .add-feedback-form{
            padding:5px 10px;
        }
        .templates ul{list-style:none}
        .templates ul li{width:84px;}
        .add-feedback-opts a.button{
            background:#d1e2f1 url(/img/button-highlight.png) top repeat-x;
            color:#6b8194;
            padding:4px 11px;
            -webkit-border-radius:12px;
            -moz-border-radius:12px;
            border-radius:12px;
            border:1px solid #9ebdd8;
            font-weight:bold;
        }
        .add-feedback-opts a.button:hover{background:#dce9f5;}
        
        .add-feedback-opts a.button-gray{
            background:#eceff1 url(/img/button-highlight.png) top repeat-x;
            color:#6b8194;
            padding:4px 11px;

            -webkit-border-radius:12px;
            -moz-border-radius:12px;
            border-radius:12px;
            border:1px solid #c1c8d0;
            font-weight:bold;
        }
        .add-feedback-opts a.button-gray:hover{background:#dce9f5;}
        #add-feedback-preview{
            width:360px;
            margin-left:19px;
            float:left;
            position:absolute;
            top:20px;
            left:200px;
            }
            .add-feedback-block{
                border:1px solid #c8ced2;
                -webkit-border-radius:4px;
                -moz-border-radius:4px;
                border-radius:4px;
                margin-bottom:15px;
                overflow:hidden;
            }
            .add-feedback-block h2{
                display:block;
                border-top:1px solid #ffffff;
                border-bottom:1px solid #c8ced2;
                color:#8a9196;
                text-shadow:#fafafa 0px 1px;
                font-size:14px;font-weight:bold;
                padding:8px 12px;
                background:#eceff1;
            }
            .add-feedback-block .html-code textarea{display:block;width:338px;height:133px;border:none;padding:10px;font-size:11px;} 
            .add-feedback-form{ padding:5px 10px; }
            .add-feedback-form label{padding-left:6px;}
            .add-feedback-form .custom-message{float:left;list-style:none;padding-left:10px;}
            .add-feedback-form .custom-message li{margin:0px;padding:0px;font-size:11px;}
            .add-feedback-opts span.gray{color:#707d87;font-size:10px;}
            .error-message{background:url(/img/yellow-error.png) repeat;padding:10px 30px;color:#565758;margin:0px -20px;font-weight:bold;}
            .float-right{float:right;}
            
            /* rating page */
            .rate-slider{width:517px;height:33px;background:url(/img/rate-slider.png);margin-top:8px;position:relative;}
            .rate-slider #rate_e,.rate-slider #rate_g,.rate-slider #rate_a,.rate-slider #rate_p,.rate-slider #rate_b{float:left;height:33px;position:relative;cursor:pointer;}
            .rate-slider #track_ball{width:30px;height:33px;position:absolute;background:url(/img/trackball.png) no-repeat;left:244px;}
            .rate-slider #rate_e,.rate-slider #rate_b{width:65px;}
            .rate-slider #rate_g,.rate-slider #rate_a,.rate-slider #rate_p{width:129px;}
            
            .ratings{color:#adafb0;font-size:12px;font-weight:bold;}
            .ratings ul{margin:0px;padding:0px;position:relative;height:30px;}
            .ratings ul li	   	  {list-style:none;display:inline;margin:0px;padding:0px;position:absolute;top:0px;background:none !important;text-shadow:none !important;}
            .ratings ul li.poor	  {left:117px;}
            .ratings ul li.average{left:234px;}
            .ratings ul li.good	  {left:370px;}
            .ratings ul li.excellent {left:446px;}

            .rate{float:right;width:517px;}
            .rate-text{float:left;padding-top:16px;}
</style>
