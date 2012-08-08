<?=Form::open_for_files('settings/save_companysettings')?>
<?=Form::hidden('companyid', $user->companyid)?>
<?=Form::hidden('logo', $company->logo)?>

<?=Form::hidden('forward_to', Input::get('forward_to'))?>
<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <h3>COMPANY PROFILE SETTINGS</h3>
</div>
<div class="block">
    <p><strong>Company Social Links</strong><br/>
    <span class="light-blue">socials links are your company homepages on social networking sites. (e.g.) Facebook, Twitter etc.</span>
    </p>

    <div class="label"><label>Facebook Company Link: </label></div>
    <div class="input-field">
        <input type="text" name="fb_link" class="regular-text" value="<?=$company->fb_link?>"/> 
    </div>

    <div class="label"><label>Twitter Company Link: </label></div>
    <div class="input-field">
        <input type="text" name="twit_link" class="regular-text" value="<?=$company->twit_link?>"/> 
    </div>

    <? $social_links = json_decode($company->social_links); ?>
    <div class="label"><label>Social Link 1: </label></div>
    <div class="input-field">
        <input type="text" name="social_links[]" class="regular-text" 
               value="<?=($social_links and array_key_exists(0, $social_links)) ? $social_links[0] : null?>"/> 
    </div>

    <div class="label"><label>Social Link 2: </label></div>
    <div class="input-field">
        <input type="text" name="social_links[]" class="regular-text" 
               value="<?=($social_links and array_key_exists(1, $social_links)) ? $social_links[1] : null?>"/> 
    </div>

    <div class="label"><label>Social Link 3: </label></div>
    <div class="input-field">
        <input type="text" name="social_links[]" class="regular-text" 
               value="<?=($social_links and array_key_exists(2, $social_links)) ? $social_links[2] : null?>"/> 
    </div>

    <br/><br/><br/><br/><br/><br/><br/>

    <p><strong>Company Description</strong><br />
    <span class="light-blue">a short description about your company</span></p>

<textarea class="regular-text" rows="20" name="company_desc">
<?=$company->description?>
</textarea> 

    <br/>

    <div class="grids">

        <?if($error):?>
            <p class="error-msg"><?=$error?></p>
        <?endif?>
        <div class="g1of3">
            <span id="ajax-upload-url" hrefaction="<?=URL::to('/settings/upload')?>"></span>
            <p><strong>Add Company Logo</strong><br /> 
               <span class="light-blue">logo size should be atleast 250x180</span></p>
            <?if($company->logo):?>
                <?=HTML::image('company_logos/'.$company->logo)?>
            <?else:?>
                <?=HTML::image('img/company-logo-filler.jpg')?>
            <?endif?>

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
