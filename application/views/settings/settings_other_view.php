<?=Form::open('settings/save_other_settings','post',array('id'=>'other_settings_form'))?>
<?=Form::hidden('companyid', $user->companyid,array('id'=>'companyid'))?>
<div id="theFormSetup" class="dashboard-page">
	<h1>Other Settings</h1>
    <div id="layout-message" class="alert-message" style="display:none"><div class="success">Settings has been updated.</div></div>
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Company Information </span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
              <div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Company Name : </div>
                      <div class="form-setup-elem">
                        <input name="company_name" type="text" id="company_name" class="dashboard-text" title="" maxlength="45" value="<?=$company_info->billto?>" />
                        <span id="company_name_error_msg" style="display:none" class="social_url_msg error_msg rounded_corner">Invalid company name</span>
                      </div>
                    </div>
                </div>
                <div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Description : </div>
                      <div class="form-setup-elem">
                        <p id="desc_hint" style="<?= (trim($panel->description) == '' ? '' : 'display: none;'); ?>">
                            This will be shown on your main public page
                        </p>
                        <div id="panel_desc_container" class="rounded_corner">
                          <p class="companyDescription break-word"><?= nl2br(HTML::entities($panel->description)); ?></p>
                        </div>
                        <textarea name="company_desc" id="panel_desc_textbox" style="display:none" class="dashboard-textarea" title="The fitness center Default" maxlength="500"><?= nl2br(HTML::entities($panel->description)); ?></textarea>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Social Media </span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
            	<div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Facebook : </div>
                      <div class="form-setup-elem">
                        <input name="company_fb" type="text" id="fb_url" class="social_url dashboard-text" title="The fitness center Default" maxlength="255" value="<?= $panel->facebook_url; ?>" />
                        <span id="fb_url_error_msg" style="display:none" class="social_url_msg error_msg rounded_corner">Invalid URL</span>
                        <span id="fb_url_success_msg" style="display:none" class="social_url_msg success_msg rounded_corner">URL is valid</span>
                      </div>
                    </div>
                </div>
                <div class="form-setup-block">
                    <div class="form-setup-fields grids">
                      <div class="form-setup-label">Twitter : </div>
                      <div class="form-setup-elem">
                        <input name="company_tw" type="text" id="tw_url" class="social_url dashboard-text" title="The fitness center Default" maxlength="255" value="<?= $panel->twitter_url; ?>" />
                        <span id="tw_url_error_msg" style="display:none" class="social_url_msg error_msg rounded_corner">Invalid URL</span>
                        <span id="tw_url_success_msg" style="display:none" class="social_url_msg success_msg rounded_corner">URL is valid</span>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>
</div>
<?=Form::close()?>
<?=$fullpage_css?>