<script type="text/javascript">
$(document).ready(function(){
	$('#password,#repeatpassword').hide();
	$(".regular-text").focus(function(i){								
			
			if ($(this).val() == $(this)[0].title){
				$(this).val("");
			}

		});

    $(".regular-text").blur(function(){
			if ($.trim($(this).val()) == ""){

				$(this).addClass("reg-text-active");

				$(this).val($(this)[0].title);
			}
		});
		
   	$(".regular-text").blur();  
	
	$('#choosepassword').focus(function(){
		$(this).hide();
		$('#password').show();
		$('#password').focus();
	});
	
	$('#chooserepeatpassword').focus(function(){
		$(this).hide();
		$('#repeatpassword').show();
		$('#repeatpassword').focus();
	});
	
	$('#password').blur(function(){
		if($(this).val() <= 0){
			$(this).hide();
			$('#choosepassword').show().blur();
		}
	});
	
	$('#repeatpassword').blur(function(){
		if($(this).val() <= 0){
			$(this).hide();
			$('#chooserepeatpassword').show().blur();
		}
	});
});
</script>
<style>
	body{margin:0;padding:0;position:relative;height:100%;width:100%;font-family:Verdana, Geneva, sans-serif}
	
	.mainWrapper{width:100%;position:relative;}
	.mainContent{width:565px;position:relative;margin:0 auto;}
	
	.formBody{
		margin-top:40px;
		box-shadow:#666 0px 0px 5px;
		background:#FFF;
		-webkit-border-radius:6px;
		-moz-border-radius:6px;		
		border-radius:6px;
		padding-bottom:20px;
	 }
	 .formHeader{padding:10px 30px;color:#1a2423;}
	 .formTable{padding:10px 30px;color:#1a2423;text-align:center;}
	 .formTable input[type="text"],.formTable input[type="password"]{display:block;margin:0 auto;padding:10px 8px;width:300px;font-size:16px;color:#999;font-weight:bold;
	 							  	-webkit-border-radius:4px;
									-moz-border-radius:4px;		
									border-radius:4px;border:1px solid #CCC;margin-bottom:4px;}
	 .formTable label{font-size:10px;color:#CCC;}
	 .formTable form{text-align:center;}
	 .formHeader h1{font-size:23px;}
	 .formHeader p{color:#576565}
	 .formUploadPhoto{padding:20px 30px;}
	 .create-account{background:url(/img/create-account-btn.jpg) top no-repeat;width:265px;height:49px;border:none;}
	 .create-account:hover{background-position:bottom;cursor:pointer;}	 
	 /* hide some input elemnets */
</style>
<div class="mainWrapper">
	<div class="mainContent">
    	<div class="formBody">
        	<div class="formHeader">
            	<h1>Hi, <?=ucfirst($user_data[0])?>. Let's finish setting up your 36Stories account!</h1>
                <p>If you already have an account, <?=HTML::link('/login', 'Sign')?> in with the username and password you already have.</p>
            </div>
            
            <div class="formTable">
                <?=Form::open('api/create_user')?> 
                    <input type="hidden" name="companyId" value="<?=$admin_details->companyid?>" />
                    <input type="hidden" name="userId" value="<?=$admin_details->userid?>" />
                    <input type="hidden" name="params" value="<?=$encrypt_string?>" />
                    <!--Photo Stuff here-->
                    <!--
                    <div class="block formUploadPhoto" style="margin-left: auto; margin-right: auto; width: 12em">
                        <div class="grids">
                            <div>
                                <div>
                                    <?if(isset($admin_details) && $avatar = $admin_details->avatar):?> 
                                        <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Your Photo</label></div>
                                        <?=HTML::image('uploaded_cropped/150x150/'.$avatar, false,
                                           array( 'id' => 'profile_picture'
                                                 , 'style' => 'border:2px solid #CCC;'
                                                 , 'width' => 97))?>
                                        <input type="hidden" name="existing_avatar" value="<?=$avatar?>" />
                                    <?else:?>
                                        <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Photo</label></div>
                                        <?=HTML::image('img/blank-avatar.png', false, 
                                            array( 'id' => 'profile_picture'
                                                 , 'style' => ' border:2px solid #CCC;'
                                                 , 'width' => 97))?>
                                    <?endif?>
                                </div>
                            </div>
                            <div>
                                <span id="ajax-upload-url" hrefaction="<?=URL::to('/widget/form/upload')?>"></span>
                                <span id="ajax-crop-url" hrefaction="<?=URL::to('/widget/form/crop')?>"></span>
                                <span id="ajax-delete-existing-avatar" hrefaction="<?=URL::to('/admin/delete_existing_avatar')?>"></span>

                                <input type="hidden" value="" name="cropped_image_nm" />
                                <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Add Photo</label></div>
                                <div style="font-weight:bold;">
                                    <div style="margin:5px 0px;">
                                        <input type="file" id="your_photo" class="fileupload" name="your_photo" size="2"/> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grids adjust-crop">
                            <div class="g1of3">
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
                                        <input type="hidden" id="x" name="x" />
                                        <input type="hidden" id="y" name="y" />
                                        <input type="hidden" id="w" name="w" />
                                        <input type="hidden" id="h" name="h" />
                                    </div>
                                    <div style="height:100px"></div>
                                    <input type="hidden" name="orig_image_dir" value="" />
                                    <input type="button" value="crop" class="large-btn" id="cropbtn"/>
                                </div>   
                            </div>
                        </div>
                    </div>
                    -->
                    <!--Photo Stuff here-->
                    <input type="hidden" name="companyId" value="<?=$company_id?>" />
                    
                	<input type="text" id="username" class="regular-text" name="username" value="<?=$admin_details->username?>" title="Choose Username" />
                    <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('password')."</p>" : null?>
                    <input type="text" id="choosepassword" class="regular-text" value="" title="Choose Password" />
                    <input type="password" id="password" class="regular-text" value="" name="password" title="" />

                    <input type="text" id="chooserepeatpassword" class="regular-text" value="" title="Repeat Password" />                    
                    <input type="password" id="repeatpassword" class="regular-text" name="password_confirmation" value="" title="" />
                    
                    <br />
                    <label>6 Characters or longer with atleast 1 number is the safest</label>
                    <br />
                    <br />
                    <input type="submit" class="create-account" value="" /> 
                <?=Form::close()?>
            </div>
        </div>
	</div>
</div>
