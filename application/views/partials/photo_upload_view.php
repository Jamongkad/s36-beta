<!--Photo Stuff here-->
<div class="block">
    <div class="grids">
        <div class="g1of3">
            <div>
                <?if(isset($admin_details) && $avatar = $admin_details->avatar):?> 
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

            <input type="hidden" value="" id="cropped_photo" name="cropped_image_nm" />
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
<!--Photo Stuff here-->
