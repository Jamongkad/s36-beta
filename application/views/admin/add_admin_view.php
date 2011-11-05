<?=Form::open('admin/add_admin')?>
<div class="block">
    <div class="label">&nbsp;</div><div class="input-field">Required Information</div>
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
    <select class="regular-select nomargin" name="im">
        <?foreach($ims as $im):?> 
            <option value="<?=$im->imid?>"><?=$im->name?></option>
        <?endforeach?>
    </select>
    </div>
    <div class="input-field"><input type="text" class="regular-text" /></div>
    <div class="label" style="margin:10px 0px;"	><label>Include a Personal Note</label></div>
    <div class="wide" style="margin-bottom:10px;"> This person will receive a welcome email with a link to choose<br /> their username and password. You can also add a personalized<br /> note that will appear at the bottom of the email.</div>
    <div class="wide"><textarea class="regular-text nomargin" rows="8"></textarea></div>
    <div class="c"></div>
</div>

<div class="block">
    mathew
</div>

<div class="block">
    <div class="label">&nbsp;</div><div class="input-field">Permissions</div>
    <div class="label"><label>Inbox</label></div><div class="checkboxes-field"><input type="checkbox" /> <label>Approve</label> <input type="checkbox" /> <label>Delete</label> <input type="checkbox" /> <label>Fast Forward</label> <input type="checkbox" /> <label>Flag</label> <input type="checkbox" /> <label>Sticky</label></div>
    <div class="label"><label>Features</label></div><div class="checkboxes-field"><input type="checkbox" /> <label>Unapprove</label> <input type="checkbox" /> <label>Delete</label> <input type="checkbox" /> <label>Fast Forward</label> <input type="checkbox" /> <label>Flag</label></div>
    <div class="label"><label>Display Setup</label></div><div class="checkboxes-field"><input type="checkbox" /> <label>Approve</label></div>
    <div class="label"><label>Contacts</label></div><div class="checkboxes-field"><input type="checkbox" /> <label>Approve</label></div>
    <div class="label"><label>People</label></div><div class="checkboxes-field"><input type="checkbox" /> <label>Approve</label></div>
    <div class="label"><label>Settings</label></div><div class="checkboxes-field"><input type="checkbox" /> <label>Approve</label></div>
    <div class="c"></div>
</div>
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

<div class="block noborder">
    <input type="submit" class="large-btn" value="ADD NEW ADMIN" />
</div>
</div>

<div class="c"></div>
</div>
<?=Form::close()?>
