<?=Form::open('admin/edit_admin')?>
<input type="hidden" name="companyId" value="<?=$admin_details->companyid?>" />
<input type="hidden" name="userId" value="<?=$admin_details->userid?>" />
<div class="block">
    <div class="label">&nbsp;</div><div class="input-field">Required Information</div>
    <div class="label"><label>User Name</label></div>
    <div class="input-field">
        <input type="text" name="username" class="regular-text" value="<?=$admin_details->username?>"/>
        <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('username')."</p>" : null?>
    </div>
    <div class="label"><label>Full Name</label></div>
    <div class="input-field">
        <input type="text" name="fullName" class="regular-text" value="<?=$admin_details->fullname?>"/>
        <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('fullName')."</p>" : null?>
    </div>
    <div class="label"><label>Email Address</label></div>
    <div class="input-field">
        <input type="text" name="email" class="regular-text" value="<?=$admin_details->email?>"/>
        <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('email')."</p>" : null?>
    </div>
    <div class="label"><label>Password</label></div>
    <div class="input-field">
        <input type="password" name="password" class="regular-text" value=""/>
        <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('password')."</p>" : null?>
    </div>
    <div class="label"><label>Confirm Password</label></div><div class="input-field">
        <input type="password" name="password_confirmation" class="regular-text" value=""/>
    </div> 
    <!--
    <div class="label"><label>Account Type</label></div><div class="input-field">
        <select class="regular-select nomargin" name="account_type"> 
            <option value="Admin">Admin</option> 
            <option value="CoAdmin">CoAdmin</option>
        </select>
    </div>
    -->
    <div class="c"></div>
</div>
<div class="block">
    <div class="label">&nbsp;</div><div class="input-field">Additional Information</div>
    <div class="label"><label>Title</label></div>
    <div class="input-field">
        <input type="text" name="title" class="regular-text" value="<?=$admin_details->title?>"/>
        <?=($errors) ? "<p style='color:red; padding-left:10px'>".$errors->first('title')."</p>" : null?>
    </div>
    <div class="label"><label>Office Phone/Ext.</label></div>
        <div class="input-field">
            <input type="text" name="ext" class="regular-text" value="<?=$admin_details->ext?>"/>
        </div>
    <div class="label"><label>Mobile Phone</label></div>
    <div class="input-field">
        <input type="text" name="mobile" class="regular-text" value="<?=$admin_details->mobile?>"/>
    </div>
    <div class="label"><label>Fax</label></div>
    <div class="input-field">
        <input type="text" name="fax" class="regular-text" value="<?=$admin_details->fax?>"/>
    </div>
    <div class="label"><label>Home Phone</label></div>
    <div class="input-field">
        <input type="text" name="home" class="regular-text" value="<?=$admin_details->home?>"/>
    </div>
    <div class="label">
    <select class="regular-select nomargin" name="imId">
        <?foreach($ims as $im):?> 
            <option value="<?=$im->imid?>"><?=$im->name?></option>
        <?endforeach?>
    </select>
    </div>
    <div class="input-field">
        <input type="text" class="regular-text" name="im" value="<?=$admin_details->home?>"/>
    </div>
    <div class="c"></div>
</div>

<div class="block">
    <div class="grids">
        <div class="g1of3">
            <div>
                <?if($avatar = $admin_details->avatar):?> 
                    <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Your Photo</label></div>
                    <?=HTML::image('uploaded_cropped/150x150/'.$avatar, false,
                       array( 'id' => 'profile_picture'
                             , 'style' => ' border:2px solid #CCC;'
                             , 'width' => 97))?>
                    <input type="hidden" name="existing_avatar" value="<?=$avatar?>" />
                <?else:?>
                    <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Preview</label></div>
                    <?=HTML::image('img/blank-avatar.png', false, 
                        array( 'id' => 'profile_picture'
                             , 'style' => ' border:2px solid #CCC;'
                             , 'width' => 97))?>
                <?endif?>
            </div>
        </div>
        <div class="g1of3">
            <span id="ajax-upload-url" hrefaction="<?=URL::to('/widget/form/upload')?>"></span>
            <span id="ajax-crop-url" hrefaction="<?=URL::to('/widget/form/crop')?>"></span>
            <span id="ajax-delete-existing-avatar" hrefaction="<?=URL::to('/admin/delete_existing_avatar')?>"></span>

            <input type="hidden" value="" name="cropped_image_nm" />
            <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Add Photo</label></div>
            <div style="padding-left:10px;font-weight:bold;">
                <div style="margin:5px 0px;">
                    <input type="file" id="your_photo" class="fileupload" name="your_photo"/> 
                </div>
            </div>
        </div>
    </div>
    <div class="grids adjust-crop">
        <div class="g1of3">
            <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Adjust and crop your image</label></div>
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
<?if($admin->itemname == "Admin"):?>
<div class="block">
    <div class="label">&nbsp;</div><div class="input-field">Permissions</div>
    <div class="label">
        <label>Inbox|Featured|Filed Feedback</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[inbox][approve]" value="1" <?=($admin_details->inbox_approve == 1) ? "checked" : null?>/> <label>Approve</label> 
        <input type="checkbox" name="perms[inbox][feature]" value="1" <?=($admin_details->inbox_feature == 1) ? "checked" : null?>/> <label>Feature</label> 
        <input type="checkbox" name="perms[inbox][delete]" value="1"  <?=($admin_details->inbox_delete == 1) ? "checked" : null?>/> <label>Delete</label> 
        <input type="checkbox" name="perms[inbox][fastforward]" value="1" <?=($admin_details->inbox_fastforward == 1) ? "checked" : null?>/> <label>Fast Forward</label> 
        <input type="checkbox" name="perms[inbox][flag]" value="1" <?=($admin_details->inbox_flag == 1) ? "checked" : null?>/> <label>Flag</label> 
    </div>
    <div class="label">
         <label>Feedback Setup</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[feedsetup][approve]" value="1" <?=($admin_details->feedsetup_approve == 1) ? "checked" : null?>/> <label>Approve</label>
    </div>
    <div class="label">
        <label>Contacts</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[contact][approve]" value="1" <?=($admin_details->contact_approve == 1) ? "checked" : null?>/> <label>Approve</label>
    </div>
    <div class="label">
        <label>Settings</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[setting][approve]" value="1" <?=($admin_details->setting_approve == 1) ? "checked" : null?>/> <label>Approve</label>
    </div>
    <div class="c"></div>
</div>
<?endif?>
<div class="block noborder">
    <input type="submit" class="large-btn" value="EDIT ADMIN" />
</div>
</div>

<div class="c"></div>
</div>
<?=Form::close()?>
