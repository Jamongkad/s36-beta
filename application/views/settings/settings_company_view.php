<?=Form::open('settings/save_companysettings')?>
<?=Form::hidden('companyid', $user->companyid)?>
<?=Form::hidden('forward_to', Input::get('forward_to'))?>
<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <h3>COMPANY PROFILE SETTINGS</h3>
</div>
<div class="block">
    <p><strong>Company Name</strong></p>
    <input type="text" class="regular-text" name="company_name" value="<?=$user->companyname?>" style="width:200px"/>
    <br />

    <p><strong>Company Social Links</strong><br/>
    <span class="light-blue">socials links are your company homepages on social networking sites. (e.g.) Facebook, Twitter etc.</span>
    </p>

    <div class="label"><label>Social Link 1: </label></div>
    <div class="input-field">
        <input type="text" name="social_link[]" class="regular-text" value=""/> 
    </div>

    <div class="label"><label>Social Link 2: </label></div>
    <div class="input-field">
        <input type="text" name="social_link[]" class="regular-text" value=""/> 
    </div>

    <div class="label"><label>Social Link 3: </label></div>
    <div class="input-field">
        <input type="text" name="social_link[]" class="regular-text" value=""/> 
    </div>

    <br/><br/><br/><br/>
    <br/><br/><br/>

    <p><strong>Company Description</strong><br />
    <span class="light-blue">a short description about your company</span></p>
    <textarea class="regular-text" rows="20" name="company_desc">
    </textarea> 
    <br/>

    <div class="grids">
        <div class="g1of3">
            <span id="ajax-upload-url" hrefaction="<?=URL::to('/settings/upload')?>"></span>
            <p><strong>Add Company Logo</strong><br /> 
               <span class="light-blue">logo size should be atleast 250x180</span></p>
            <?=HTML::image('img/company-logo-filler.jpg')?>
            <div style="padding-left:10px;font-weight:bold;">
                <div style="margin:5px 0px;">
                    <input type="file" id="your_photo" class="fileupload" name="your_photo"/> 
                </div>
            </div>
        </div>
    </div>

    <div style="padding-top:20px; padding-bottom:30px; padding-left:5px">
        <input type="submit" class="large-btn" value="Save Settings" />
    </div>
</div>
<?=Form::close()?>
