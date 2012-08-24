<?=Form::open_for_files('settings/save_companysettings')?>
<?=Form::hidden('companyid', $user->companyid)?>
<?=Form::hidden('logo', $company->logo)?>

<?=Form::hidden('forward_to', Input::get('forward_to'))?>
<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <h3>COMPANY PROFILE SETTINGS</h3>
</div>
<div class="block">    
    <p class="small"><strong></strong></p>
    <div class="grids border-bottom">
        <div class="g3of4">
            <div class="grids">
                <div class="g1of3"><strong>Name</strong> <br />This name will appear <br />on your hosted page</div>
                <div class="g2of3"><input type="text" class="regular-text" /></div>
            </div>
            <br />
            <div class="grids">
                <div class="g1of3"><strong>Add Company Logo</strong> <br />Select your company's logo and upload it here, you can  adjust it once it's been uploaded.</div>
                <div class="g2of3"><br /><input type="file" id="your_photo" class="fileupload regular-text" name="your_photo" /> </div>
            </div>
            
            <br />
            <div class="grids">
            	<?if($error):?>
                    <p class="error-msg"><?=$error?></p>
                <?endif?>
            </div>
            <div class="grids">
                <div id="image-container">
                <span id="ajax-upload-url" hrefaction="<?=URL::to('/settings/upload')?>"></span>
                <?if($company->logo):?>
            	    <?=HTML::image('company_logos/'.$company->logo)?>
	            <?else:?>
    	            <?=HTML::image('img/company-logo-filler.jpg')?>
        	    <?endif?></div>
            </div>
            <br />
            <div class="grids">
                <div class="g1of3"><strong>Company Description</strong> <br />A short description about<br /> your company 500 char<br /> limit.</div>
                <div class="g2of3">
                <textarea class="regular-text" rows="20" name="company_desc"><?=$company->description?></textarea>
				</div>
            </div>
            <br />
            <div class="grids">
                <div class="g1of3"><strong class="facebook-icon">Facebook URL : </strong></div>
                <div class="g2of3"><input type="text" name="fb_link" class="regular-text" value="<?=$company->fb_link?>"/></div>
            </div>
            <br />
            <div class="grids">
                <div class="g1of3"><strong class="twitter-icon">Twitter URL : </strong></div>
                <div class="g2of3"><input type="text" name="twit_link" class="regular-text" value="<?=$company->twit_link?>"/></div>
            </div>
            <br />
            <? $social_links = json_decode($company->social_links); ?>
            <div class="grids">
                <div class="g1of3"><strong class="website-icon">Social Link 1 : </strong></div>
                <div class="g2of3"><input type="text" name="social_links[]" class="regular-text" 
                value="<?=($social_links and array_key_exists(0, $social_links)) ? $social_links[0] : null?>"/> 
                </div>
            </div> 
            <br />
            <div class="grids">
                <div class="g1of3"><strong class="website-icon">Social Link 1 : </strong></div>
                <div class="g2of3"><input type="text" name="social_links[]" class="regular-text" 
                value="<?=($social_links and array_key_exists(1, $social_links)) ? $social_links[1] : null?>"/> 
                </div>
            </div> 
            <br /> 
            <div class="grids">
                <div class="g1of3"><strong class="website-icon">Social Link 1 : </strong></div>
                <div class="g2of3"><input type="text" name="social_links[]" class="regular-text" 
                value="<?=($social_links and array_key_exists(2, $social_links)) ? $social_links[2] : null?>"/>
                </div>
            </div> 
            <br /> 
        </div>
        <div class="g1of4">
            &nbsp;
        </div>
    </div>
    <br /> 
    <div class="grids">
        <div class="g3of4">
            <div class="grids">
                <strong><a href="#" style="text-decoration:underline">Preview this on your public feedback page</a></strong>
                <p>If you leave a field empty, it will not appear on your <a href="#" style="text-decoration:underline">public feedback page</a></p>
                <br />
                <input type="submit" class="large-btn" value="Save Settings" />
            </div>
        </div>
        <div class="g1of4">
            &nbsp;
        </div>
    </div>
</div>

<?=Form::close()?>
