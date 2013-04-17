<?= HTML::script('/js/jquery.iframe-transport.js'); ?>
<?= HTML::script('/js/jquery.ui.widget.js'); ?>
<?= HTML::script('/js/jquery.fileupload.js'); ?>
<?= HTML::script('/js/helpers.js'); ?>
<?= HTML::script('/js/inbox/Status.js'); ?>
<?=Form::open_for_files('settings/save_companysettings')?>
<?=Form::hidden('companyid', $user->companyid, array('id' => 'company_id'))?>
<?=Form::hidden('logo', $company->logo, array('id' => 'logo'))?>
<?=Form::hidden('forward_to', Input::get('forward_to'))?>
<div class="block graybg" style="margin-top:10px;border-top:1px solid #dedede;">
    <h3>COMPANY PROFILE SETTINGS</h3>
</div>
<div class="block">    
    <p class="small"><strong></strong></p>
    <div class="grids border-bottom">
        <div class="g4of5">
            <div class="grids">
                <div class="g2of5"><strong>Name</strong> <br />This name will appear <br />on your hosted page</div>
                <div class="g3of5"><input type="text" class="regular-text" name="fullpagecompanyname" value="<?=$company->fullpagecompanyname?>"/></div>
            </div>
            <br />
            <div class="grids">
                <div class="g2of3"><strong>Add Company Logo</strong> <br />Select your company's logo and upload it here, it will be uploaded upon pressing the 'Save Settings' button.</div>
                <div class="g2of3"><br />
                    <!-- <input type="file" name="your_photo" id="your_photoXXX" class="fileupload regular-text" /> -->
                    <input type="file" id="company_logo" data-url="/imageprocessing/upload_company_logo" />
                </div>
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
                    <div id="image-sub-container">
                        <?if($company->logo):?>
                            <img src="/uploaded_images/company_logos/<?php echo $company->logo . '?' . str_shuffle(md5('get rid of cache')); ?>" width="100%" />
                        <?else:?>
                            <img src="/img/company-logo-filler.jpg" width="100%" />
                        <?endif?>
                    </div>
                </div>
            </div>
            <br />
            <div class="grids">
                <div class="g2of5"><strong>Company Description</strong> <br />A short description about<br /> your company 500 char<br /> limit.</div>
                <div class="g3of5">
                <textarea class="regular-text" rows="8" name="company_desc"><?=$company->description?></textarea>
				</div>
            </div>
        </div>
        <div class="g1of4">
            &nbsp;
        </div>
    </div>
    <br /> 
    <!-- <div class="grids">
        <div class="g3of4">
            <div class="grids">
                <strong>
                    <a href="<?=$url?>" id="preview-link" class="dark-blue" target="_blank" style="text-decoration:underline">Link preview this on your public feedback page</a>
                </strong>
                <p>If you leave a field empty, it will not appear on your public feedback page</p>
                <br />
                <input type="submit" class="large-btn" value="Save Settings" />
            </div>
        </div>
        <div class="g1of4">
            &nbsp;
        </div>
    </div> -->
</div>

<?=Form::close()?>

<script type="text/javascript">
jQuery(function($) {
    var fullname = $('input[name="fullpagecompanyname"]');

    if(fullname.val() != "") { 
        $("a#preview-link").attr('href', '<?=$url?>' + '?sample_name='+ fullname.val());
    }

    $(document).delegate('input[name="fullpagecompanyname"]', 'keyup', function(e) { 
        $("a#preview-link").attr('href', '<?=$url?>' + '?sample_name='+ $(this).val());
    });
    
    
    var myStatus = new Status();
    
    $('#company_logo').fileupload({
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
            //myStatus.notify('Changing Profile Picture', 3000);
            $('#image-sub-container img').css('opacity', '0.2');
        },done: function(e, data){
            // set the new src for the image. the additional ? or any get param at the end of the src
            // refereshes the displayed image. this is it dan, you bits!
            // we also need the ext from result because they differ from server side.
            var ext = data.result[0].name.split('.').pop();
            var rand_str = '?' + Helpers.get_random_str(5);
            var new_src = '/uploaded_images/uploaded_tmp/logo_' + $('#company_id').val() + '.' + ext + rand_str;
            $('#image-sub-container img').attr('src', new_src).animate({'opacity': '1'});
            $('#logo').val('logo_' + $('#company_id').val() + '.' + ext);
            //self.hide_notification();
        }
    });
})
</script>
