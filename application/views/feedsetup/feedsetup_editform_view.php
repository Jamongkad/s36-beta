<?=Form::open('feedsetup/save_form_widget', 'POST', array('id' => 'create-form-widget'))?>
<?$site_id = Input::get('site_id')?>
<?=Form::hidden('widget_type', 'submit')?>
<?=Form::hidden('company_id', $widget->companyid)?>
<?=Form::hidden('site_id', $widget->siteid)?>
<?=Form::hidden('submit_widgetkey', $widget->widgetkey)?>
<?=Form::hidden('theme_type', $widget->widgetattr->theme_type, Array('id' => 'selected-form'))?>
<?=Form::hidden('tab_type', $widget->widgetattr->tab_type, Array('id' => 'selected-tab'))?>
<?=Form::hidden('embed_type', 'form')?>

<?=Form::hidden('theme_name', $widget->widgetattr->theme_name)?>
<?=Form::hidden('submit_form_text', '')?>
<?=Form::hidden('submit_form_question', '')?>

<span id="preview-form-widget-url" hrefaction="<?=URL::to('feedsetup/preview_widget_style')?>"></span>
<span id="formcode-manager-url" hrefaction="<?=URL::to('feedsetup/formcode_manager')?>"></span>
<span id="preview-widget" hrefaction="<?=URL::to('/feedsetup/generate_code')?>"></span>
<div id="theFormSetup" class="dashboard-page">
<h1>Form Setup</h1>
<?php
/* --as instructed by ryan, remove step 1 and 2--
<div class="dashboard-box">
    <div class="dashboard-head">
      <span class="dashboard-title">Step 1 :</span> <span class="dashboard-subtitle">Choose a name for your form</span>
    </div>
    <div class="dashboard-body">
        <div class="dashboard-content">
            <div class="form-setup-block">
                <div class="form-setup-fields grids">
                    <div class="form-setup-label">Form Name : </div>
                    <div class="form-setup-elem">
                        <input name="theme_name" type="text" class="dashboard-text" title="<?=$widget->widgetattr->theme_name?>" value="<?=$widget->widgetattr->theme_name?>" /></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dashboard-box">
    <div class="dashboard-head">
      <span class="dashboard-title">Step 2 :</span> <span class="dashboard-subtitle">Choose a question to encourage your users</span>
    </div>
    <div class="dashboard-body">
        <div class="dashboard-content">
            <div class="form-setup-block">
                <div class="form-setup-fields grids">
                    <div class="form-setup-label">Form Header Text : </div>
                    <div class="form-setup-elem grids">
                        <div class="g2of3">
                            <input name="submit_form_text" type="text" class="dashboard-text" title="<?=$widget->widgetattr->submit_form_text?>" value="<?=$widget->widgetattr->submit_form_text?>" />
                        </div>
                    </div>
                </div>
                <div class="form-setup-fields grids">
                    <div class="form-setup-label">What to write? </div>
                    <div class="form-setup-elem grids">
                        <div class="g2of3">
                            <textarea name="submit_form_question" class="dashboard-textarea" title="<?=$widget->widgetattr->submit_form_question?>"><?=$widget->widgetattr->submit_form_question?></textarea>
                        </div>
                        <div class="g1of3">
                            <p class="dashboard-your-question">Questions to help your 
                                customers/visitors respond 
                                to your form in a certain way. 
                                This text will appear if they 
                                click "What to write?".</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
*/ ?>
<div class="dashboard-box">
    <div class="dashboard-head">
      <span class="dashboard-title">Create custom fields for your form (optional)</span> <span class="dashboard-subtitle"></span>
    </div>
    <div class="dashboard-body">
        <div class="dashboard-content">
            <div id="feedbacksetup-message" class="alert-message" style="display:none;">
                <div class="success">Feedback form has been updated.</div>
            </div>
            <p class="dashboard-your-question">Custom fields are additional information you would want to collect from your customers. Information such as what sort of color they prefer, or maybe you might want them to specify their gender. With custom fields, you have the flexibility to collect information in addition to your customer's feedback.</p>
            <div my-formbuilderload widget_key="<?=$widget->widgetkey?>" id="form-builder" class="grids"></div>
        </div>
    </div>
</div>
<p><input type="submit" class="dashboard-button blue large" value="Update" style="cursor:pointer"/></p>
</div>
<?=Form::close()?>

<script type="text/javascript">
$(document).ready(function(){
    
    $('#create-form-widget').submit(function(){
        $.ajax({
            url: $('#create-form-widget').attr('action'),
            type: 'post',
            dataType: 'json',
            data: $('#create-form-widget').serialize(),
            beforeSend: function(){
                $('#notification-message').empty().html('Updating feedback settings..');
                $('#notification').animate({ height: '50', opacity: '100' }, 'fast','',function(){
                  setTimeout($("#notification").animate({ height: 0, opacity: 0 }, 'fast'),1000);
                });
            },
            success: function(responseText) {
              
                var widget_key      = responseText.widgetkey;
                var widget_store_id = responseText.widgetstoreid;
                var company_id      = responseText.company_id;
                var formcode_url    = $("#formcode-manager-url").attr('hrefaction') + "/" + widget_key;

                $.ajax({
                    type: "POST"
                  , dataType: 'json'       
                  , url: "/feedsetup/buildmetadata_options"
                  , data: $("ul[id^=frmb-]").serializeFormList({ prepend: "frmb" }) + "&form_id=" + widget_store_id + "&company_id=" + company_id
                  , success: function(msg) {
                        if(msg.status == 'invalid' && msg.validation.length > 0) {
                            for(var i=0; i<msg.validation.length; i++) {
                                var elm = $("#" + msg.validation[i]);
                                elm.css({'border': '2px solid red'});
                            }
                            $('#feedbacksetup-message').hide();
                        } else {
                            $('#feedbacksetup-message').fadeIn();
                            $('body').scrollTop(0);
                            //window.location = formcode_url;                             
                            //console.log("All good to go");
                        }                             
                    }
                });
              
            }
        });
        return false;
    });    
});
</script>
