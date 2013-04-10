<?=Form::open('feedsetup/save_form_widget', 'POST', array('id' => 'create-form-widget'))?>
<?$site_id = Input::get('site_id')?>
<?=Form::hidden('widget_type', 'submit')?>
<?=Form::hidden('company_id', $widget->companyid)?>
<?=Form::hidden('site_id', $widget->siteid)?>
<?=Form::hidden('submit_widgetkey', $widget->widgetkey)?>
<?=Form::hidden('theme_type', $widget->widgetattr->theme_type, Array('id' => 'selected-form'))?>
<?=Form::hidden('tab_type', $widget->widgetattr->tab_type, Array('id' => 'selected-tab'))?>
<?=Form::hidden('embed_type', 'form')?>

<span id="preview-form-widget-url" hrefaction="<?=URL::to('feedsetup/preview_widget_style')?>"></span>
<span id="formcode-manager-url" hrefaction="<?=URL::to('feedsetup/formcode_manager')?>"></span>
<span id="preview-widget" hrefaction="<?=URL::to('/feedsetup/generate_code')?>"></span>

<div class="block">
    <div id="widget-setup-block">
        <div class="widget-options">
            <h2><span>Step 1 :</span> Choose a name for your form and a question to encourage your users</h2>
            <div class="widget-types">
                <table width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                        <td width="120">
                            <strong style="font-size:14px;">Form Name :</strong>
                        </td>
                        <td><input type="text" class="large-text" name="theme_name" value="<?=$widget->widgetattr->theme_name?>" title="<?=$widget->widgetattr->theme_name?>" /></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="widget-options">
            <h2><span>Step 2 :</span> Choose a name for your form and a question to encourage your users</h2>
            <div class="widget-types">
            <table width="100%" cellpadding="5" cellspacing="0">
                <tbody><tr>
                    <td width="140">
                        <strong style="font-size:14px;">Form Header Text :</strong>
                    </td>
                    <td><input type="text" class="large-text" name="submit_form_text" value="<?=$widget->widgetattr->submit_form_text?>" 
                                                                                      title="<?=$widget->widgetattr->submit_form_text?>" /></td>
                    <td rowspan="2" width="150" align="center" valign="top">
                    </td>
                </tr>
                <tr>
                    <td>
                        What to write?
                        <br />
                        <small style="line-height:normal">
                        Questions to help your customers/visitors respond to your form in a certain way. This text will appear if they click "What to write?". 
                    </td>
                    <td valign="top">
                        <textarea name="submit_form_question" class="large-textarea" 
                                  style="margin:0px;width:258px;font-family:Arial, Helvetica, sans-serif;padding:5px 8px;" rows="8" 
                                  title="<?=$widget->widgetattr->submit_form_question?>">
<?=$widget->widgetattr->submit_form_question?>
                        </textarea>
                    </td>
                </tr>
            </tbody></table>
            </div>

        </div>
        <div class="widget-options">
            <h2><span>Step 3 :</span>Create custom fields for your form (optional)</h2>
            <small style="padding: 25px;">Custom fields are additional information you would want to collect from your customers. Information such as what sort of color they prefer. 
               Or maybe you might want them to specify their gender. With custom fields, you have the flexibility to 
               collect information in addition to your customer's feedback.</small>
            <div my-formbuilderload widget_key="<?=$widget->widgetattr->widgetkey?>" style="padding: 25px" id="form-builder"></div>
        </div>
        <div class="widget-options">
            <div class="block noborder" style="margin-left:-10px;">
                <input type="submit" class="large-btn create-widget-button" value="Update" my-createform/>
            </div>
        </div>
    </div>
</div>
<?=Form::close()?>
</div>
<div class="c"></div>
</div>
