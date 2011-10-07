<script type="text/javascript">
    jQuery(function($) {
        $("#edit-code-form").bind("submit", function(e) {
            $(this).ajaxSubmit({
                beforeSubmit: function(formData, jqForm, options) {
                    $("#form-status").html("Saving changes...");
                }
              , success: function(responseText, statusText, xhr, $form) {  
                    $("#form-status").html("Success!");
                    //$('#lightbox').fadeOut('fast',function(){$(this).empty();});
                    //$('#lightbox-shadow').fadeOut('fast');
                }
            }); 
            e.preventDefault();
        });
    });
</script>
<style>
    #form-status { padding: 10px }
</style>
<h3 id="form-status"></h3>
<?=Form::open('feedsetup/edit_code', 'POST', array("id" => "edit-code-form"))?>
<?=Form::hidden('userThemeId', $user_theme_id)?>
<?=Form::hidden('widgetType', $widget_type)?>
<?=Form::hidden('companyId', $company_id)?>
<?=Form::hidden('widgetOptionId', $fetched_theme->widget_option_id)?>
<?if($fetched_theme->embed_type == 'embedded'):?>
<div class="widget-types">
    <div class="widget-opts" id="embed_widget">
        <table width="100%">
            <tr><td width="170" class="feedback-td-font">Choose Block Type</td>
                <td>
                    <input type="radio" name="embed_block_type" value="embed_block_x" id="horizontal_embed" 
                        <?=($fetched_theme->type == 'embed_block_x') ? "checked" : null?> 
                    /> 
                    <label for="horizontal_embed" class="feedback-td-font">Horizontal</label>
                </td>
                <td>
                    <input type="radio" name="embed_block_type" value="embed_block_y" id="vertical_embed"  
                        <?=($fetched_theme->type == 'embed_block_y') ? "checked" : null?> 
                    /> 
                    <label for="vertical_embed" class="feedback-td-font">Vertical</label>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?=HTML::image('img/preview-horizontal-embed.png')?>
                </td>
                <td>
                    <?=HTML::image('img/preview-vertical-embed.png')?>
                </td>
            </tr>
            <tr>
                <td class="feedback-td-font">Units to Display per page : </td>
                <td colspan="2">
                    <select name="embed_units" class="regular-select">
                        <option value="0">-</option>
                        <?for($i=1;$i <= 5;++$i):?> 
                            <option value="<?=$i?>" <?=($fetched_theme->units == $i) ? 'selected' : null?>><?=$i?></option>
                        <?endfor?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="feedback-td-font">Display Size : </td>
                <td colspan="2" class="feedback-td-font">
                    Width (px): <input type="text" class="regular-text small-text" value="<?=$fetched_theme->width?>" style="display:inline;" name="embed_width"/>
                    Height (px): <input type="text" class="regular-text small-text" value="<?=$fetched_theme->height?>" style="display:inline;" name="embed_height"/>
                </td>
            </tr>
            <tr>
                <td class="feedback-td-font">Transition Effect : </td>
                <td colspan="2">
                    <select name="embed_effects" class="regular-select"> 
                      
                        <option value="0">-</option> 
                        <?foreach($effects_options as $rows):?>        
                            <option value="<?=$rows->effectsid?>" <?=($fetched_theme->effect == $rows->effectsid) ? "selected" : null?> ><?=$rows->effectsname?></option>
                        <?endforeach?>
                    </select>
                </td>
            </tr>
        </table>
    </div>
</div>
<?endif?>
<?if($fetched_theme->embed_type == 'modal'):?>
<div class="widget-types">
    <div class="widget-opts" id="modal_widget">
        <table width="100%">
            <tr><td width="170" class="feedback-td-font">Transition :</td>
                <td>
                    <select name="modal_effects" class="regular-select">       
                        <option value="0">-</option>
                        <?foreach($effects_options as $rows):?>        
                            <option value="<?=$rows->effectsid?>" <?=($fetched_theme->effect == $rows->effectsid) ? "selected" : null?> ><?=$rows->effectsname?></option>
                        <?endforeach?>
                    </select>
                </td>
            </tr>
            <tr><td></td>
                <td>
                    <?=HTML::image('img/preview-modal.png')?>
                </td>
            </tr>
        </table>
    </div>
</div>
<?endif?>
<div class="widget-options">
    <div class="templates" id="template-slider">
       <?foreach($themes as $theme):?>
           <span id="themeId_<?=$theme->themeid?>" >
                <input type="radio" name="theme_id" value="<?=$theme->themeid?>"
                    <?=($fetched_theme->theme_id == $theme->themeid) ? "checked" : null ?>
                /> <?=$theme->name?>
           </span>
       <?endforeach?>
    </div>
</div>
<input type="submit" value="edit" />
<?=Form::close();?>
