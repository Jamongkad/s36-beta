<?= HTML::script('/js/jquery.iframe-transport.js'); ?>
<?= HTML::script('/js/jquery.ui.widget.js'); ?>
<?= HTML::script('/js/jquery.fileupload.js'); ?>
<?= HTML::script('/js/helpers.js'); ?>
<?= HTML::script('/js/inbox/Status.js'); ?>
<?=Form::open_for_files('admin/edit_admin')?>
<input type="hidden" name="companyId" value="<?=$admin_details->companyid?>" />
<input type="hidden" name="userId" value="<?=$admin_details->userid?>" id="user_id" />
<input type="hidden" name="avatar" value="<?=$admin_details->avatar?>" id="avatar" />
<input type="hidden" name="tmp_avatar" value="" id="tmp_avatar" />
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

<?//=$photo_upload_view?>
<!-- Photo Stuff here-->
<div class="block">
    <div class="grids">
        <div class="g1of3">
            <div>
                <?if(isset($admin_details) && $avatar = $admin_details->avatar):?>
                    <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Your Photo</label></div>
                    <div id="upload-image-container" class="admin-avatar-container" style="border: 2px solid #CCC;">
                        <img src="/uploaded_images/admin_avatar/<?php echo $admin_details->avatar . '?' . str_shuffle(md5('get rid of cache')); ?>" width="48px" height="48px" />
                    </div>
                <?else:?>
                    <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Preview</label></div>
                    <div id="upload-image-container" class="admin-avatar-container" style="border: 2px solid #CCC;">
                        <img src="/img/blank-avatar.png" width="48px" height="48px" />
                    </div>
                <?endif?>
            </div>
        </div>
        <div class="g1of3">
            <div style="font-size:11px; font-weight:bold; padding: 8px 0 0"><label>Add Photo</label></div>
            <div style="padding-left:10px;font-weight:bold;">
                <div style="margin:5px 0px;">
                    <input type="file" id="avatar_uploader" data-url="/imageprocessing/upload_admin_avatar" />
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of Photo Stuff here-->

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
    <input type="submit" class="large-btn" value="SAVE SETTINGS" /> or <?=HTML::link('admin', 'cancel')?>
</div>
</div>

<div class="c"></div>
</div>
<?=Form::close()?>
<script type="text/javascript">
    var myStatus = new Status();
    $('#avatar_uploader').fileupload({
        dataType: 'json',
        add: function(e, data){
            var image_types = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
            if( image_types.indexOf( data.files[0].type ) == -1 ){
                myStatus.notify('Please select an image file', 3000);
                return false;
            }
            if( data.files[0].size > 2000000 ){
                myStatus.notify('Please upload an image not greater than 2mb in filesize', 3000);
                return false;
            }
            data.submit();
        },progress: function(e, data){
            $('#upload-image-container img').css('opacity', '0.2');
        },done: function(e, data){
            var filename = data.result[0].name;
            var ext = data.result[0].name.split('.').pop();
            var rand_str = '?' + Helpers.get_random_str(5);
            var new_src = '/uploaded_images/uploaded_tmp/' + filename + rand_str;
            $('#upload-image-container img').attr('src', new_src).animate({'opacity': '1'});
            $('#avatar').val('avatar_' + $('#user_id').val() + '.' + ext);
            $('#tmp_avatar').val(filename);
        }
    });
</script>