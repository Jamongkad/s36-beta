<?=Form::open('admin/add_admin')?>
<div class="block">
    <div class="label">&nbsp;</div><div class="input-field">Required Information</div>
    <div class="label"><label>User Name</label></div><div class="input-field"><input type="text" name="username" class="regular-text" /></div>
    <div class="label"><label>Full Name</label></div><div class="input-field"><input type="text" name="fullName" class="regular-text" /></div>
    <div class="label"><label>Email Address</label></div><div class="input-field"><input type="text" name="email" class="regular-text" /></div>
    <div class="label"><label>Password</label></div><div class="input-field"><input type="password" name="password" class="regular-text" /></div>
    <div class="label"><label>Confirm Password</label></div><div class="input-field"><input type="password" name="password_confirm" class="regular-text" /></div>
    <div class="c"></div>
</div>
<div class="block">
    <div class="label">&nbsp;</div><div class="input-field">Additional Information</div>
    <div class="label"><label>Title</label></div><div class="input-field"><input type="text" name="title" class="regular-text" /></div>
    <div class="label"><label>Office Phone/Ext.</label>	</div><div class="input-field"><input type="text" name="ext" class="regular-text" /></div>
    <div class="label"><label>Mobile Phone</label></div><div class="input-field"><input type="text" name="mobile" class="regular-text" /></div>
    <div class="label"><label>Fax</label></div><div class="input-field"><input type="text" name="fax" class="regular-text" /></div>
    <div class="label"><label>Home Phone</label></div><div class="input-field"><input type="text" name="home" class="regular-text" /></div>
    <div class="label">
    <select class="regular-select nomargin" name="imId">
        <?foreach($ims as $im):?> 
            <option value="<?=$im->imid?>"><?=$im->name?></option>
        <?endforeach?>
    </select>
    </div>
    <div class="input-field"><input type="text" class="regular-text" name="im"/></div>
    <div class="label" style="margin:10px 0px;"	><label>Include a Personal Note</label></div>
    <div class="wide" style="margin-bottom:10px;"> This person will receive a welcome email with a link to choose<br /> their username and password.</div>
    <div class="wide"><textarea class="regular-text nomargin" rows="8" name="welcome_note"></textarea></div>
    <div class="c"></div>
</div>

<div class="block">
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
            <input type="hidden" value="" name="cropped_image_nm" />
            <label><strong>Add Photo :</strong> </label> <br />
            <div style="padding-left:10px;font-weight:bold;">
                <div style="margin:5px 0px;">
                    <input type="file" id="your_photo" class="fileupload" name="your_photo"/> 
                </div>
            </div>
        </div>
    </div>
    <div class="grids">
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

<div class="block">
    <div class="label">&nbsp;</div><div class="input-field">Permissions</div>
    <div class="label">
        <label>Inbox</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[inbox][approve]" value="1" checked/> <label>Approve</label> 
        <input type="checkbox" name="perms[inbox][delete]" value="1" checked/> <label>Delete</label> 
        <input type="checkbox" name="perms[inbox][fastforward]" value="1" checked/> <label>Fast Forward</label> 
        <input type="checkbox" name="perms[inbox][flag]" value="1" checked/> <label>Flag</label> 
        <!--
        <input type="checkbox" /> <label>Sticky</label>
        -->
    </div>
    <div class="label">
        <label>Features</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[feature][approve]" value="1" checked/> <label>Approve</label> 
        <input type="checkbox" name="perms[feature][delete]" value="1" checked/> <label>Delete</label> 
        <input type="checkbox" name="perms[feature][fastforward]" value="1" checked/> <label>Fast Forward</label> 
        <input type="checkbox" name="perms[feature][flag]" value="1" checked/> <label>Flag</label>
    </div>
    <div class="label">
         <label>Feedback Setup</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[feedsetup][approve]" value="1" checked/> <label>Approve</label>
    </div>
    <div class="label">
        <label>Contacts</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[contact][approve]" value="1" checked/> <label>Approve</label>
    </div>
    <!--
    <div class="label"><label>People</label></div><div class="checkboxes-field"><input type="checkbox" /> <label>Approve</label></div>
    -->
    <div class="label">
        <label>Settings</label>
    </div>
    <div class="checkboxes-field">
        <input type="checkbox" name="perms[setting][approve]" value="1" checked/> <label>Approve</label>
    </div>
    <div class="c"></div>
</div>
<!--
<div class="block">
    <div class="g1of2">
        <div class="innerblock">
            <h3>What Happens Now?</h3>
            <p>When you click the "add this person" button below, we'll fire off a nice invitation to the email address you entered above. The email will contain a link to a Web page where this person will complete the setup process by picking their own username and password. You can immediately start involving them in projects even before they've chosen their username and password.</p>
        </div>
    </div>
    <div class="g1of2">
        <div class="innerblock">
            <h3>Check out an example of a welcome email the person you are inviting will receive</h3>
            <div class="what-it-looks">
                
            </div>
        </div>
    </div>
    <div class="c"></div>
</div>
-->
<div class="block noborder">
    <input type="submit" class="large-btn" value="ADD NEW ADMIN" />
</div>
</div>

<div class="c"></div>
</div>
<?=Form::close()?>
