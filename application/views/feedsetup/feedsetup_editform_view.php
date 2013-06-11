
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



<div id="theFormSetup" class="dashboard-page">
<h1>Form Setup</h1>

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
<div class="dashboard-box">
	<div class="dashboard-head">
      <span class="dashboard-title">Step 3 :</span> <span class="dashboard-subtitle">Create custom fields for your form (optional)</span>
    </div>
    <div class="dashboard-body">
    	<div class="dashboard-content">
        	<div class="form-setup-block">
            </div>
        </div>
    </div>
</div>
<p><input type="submit" class="dashboard-button blue large" value="Update" my-createform/></p>
</div>


<?=Form::close()?>