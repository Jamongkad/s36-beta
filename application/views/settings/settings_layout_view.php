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
                                <input class="preview-layout-img" type="hidden" value="/fullpage/admin/img/traditional-preview.jpg" />
                                <input class="preview-layout-name" type="hidden" value="Traditional" />
                                <a class="layout-item" href="javascript:;"><img src="/fullpage/admin/img/traditional-layout-thumb.jpg" /></a>
                            </div>
                        </div>
                    </li>
                    <li <?=($panel->theme_name=='Timeline') ? 'class="selected"' : ''?> id="Timeline">
                        <div class="layout">
                            <h3 class="layout-name">Timeline</h3>
                            <div class="layout-thumb">
                                <input class="preview-layout-img" type="hidden" value="/fullpage/admin/img/timeline-preview.jpg" />
                                <input class="preview-layout-name" type="hidden" value="Timeline" />
                                <a class="layout-item" ref="javascript:;"><img src="/fullpage/admin/img/timeline-layout-thumb.jpg" /></a>
                            </div>
                        </div>
                    </li>
                    <li <?=($panel->theme_name=='Treble') ? 'class="selected"' : ''?> id="Treble">
                        <div class="layout">
                            <h3 class="layout-name">Treble</h3>
                            <div class="layout-thumb">
                                <input class="preview-layout-img" type="hidden" value="/fullpage/admin/img/treble-preview.jpg" />
                                <input class="preview-layout-name" type="hidden" value="Treble" />
                                <a class="layout-item" href="javascript:;"><img src="/fullpage/admin/img/treble-layout-thumb.jpg" /></a>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="layout-chooser-buttons">
                    <a id="previewLayout" href="/fullpage/admin/img/<?=strtolower($panel->theme_name)?>-preview.jpg"  Title="<?=ucfirst($panel->theme_name)?> Layout Preview" style="cursor: pointer;">Preview</a>
                    <a id="chooseLayout" href="javascript:;" class="dark-blue" style="cursor: pointer;">Choose Layout</a>
                </div>
            </div>
        </div>
        <div class="dashboard-foot noborder"></div>
    </div>
</div>
<?=$fullpage_css?>