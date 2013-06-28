<input type="hidden" id="selectedLayout" value="Traditional" />
<div id="theFormSetup" class="dashboard-page">
	<h1>Other Settings</h1>
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Social Media </span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
            	
                <ul class="layout-list clear">
                    <li <?=($panel->theme_name=='Traditional') ? 'class="selected"' : ''?> id="Traditional">
                        <div class="layout">
                            <h3 class="layout-name">Traditional</h3>
                            <div class="layout-thumb">
                                <a href="javascript:;"><img src="/fullpage/admin/img/layout-1.jpg" /></a>
                            </div>
                        </div>
                    </li>
                    <li <?=($panel->theme_name=='Timeline') ? 'class="selected"' : ''?> id="Timeline">
                        <div class="layout">
                            <h3 class="layout-name">Timeline</h3>
                            <div class="layout-thumb">
                                <a href="javascript:;"><img src="/fullpage/admin/img/layout-2.jpg" /></a>
                            </div>
                        </div>
                    </li>
                    <li <?=($panel->theme_name=='Treble') ? 'class="selected"' : ''?> id="Treble">
                        <div class="layout">
                            <h3 class="layout-name">Treble</h3>
                            <div class="layout-thumb">
                                <a href="javascript:;"><img src="/fullpage/admin/img/layout-3.jpg" /></a>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="layout-chooser-buttons">
                    <a id="previewLayout" href="javascript:;"  style="cursor: pointer;">Preview</a>
                    <a id="chooseLayout" href="javascript:;" class="dark-blue" style="cursor: pointer;">Choose Layout</a>
                </div>
            </div>
        </div>
        <div class="dashboard-foot noborder"></div>
    </div>
</div>

<?php echo $fullpage_css; ?>
<?= HTML::script('/fullpage/admin/js/Settings.js'); ?>
<?= HTML::script('/fullpage/admin/js/SettingsAutoSaver.js'); ?>
<script type="text/javascript">
    Settings.init();
    SettingsAutoSaver.init();
</script>