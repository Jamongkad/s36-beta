<div id="theFormSetup" class="dashboard-page">
	<h1>Form Setup</h1>
    <div class="dashboard-box">
    	<div class="dashboard-head">
          <span class="dashboard-title">Submission Forms</span> <span class="dashboard-subtitle">for accepting feedback from your customers/visitors</span>
        </div>
        <div class="dashboard-body">
        	<div class="dashboard-content">
            <?php 
            $widgets = $widgets->form_widgets->widget;
            if($widgets):
            foreach($widgets->widgets as $rows):
            ?>
            	<div class="form-setup-block">
                	<div class="dashboard-text-large"><?=$rows->widget_obj->theme_name?></div>
                    <a href="/feedsetup/edit/<?=$rows->widgetkey?>" class="dashboard-button gray">Edit</a>
                    <a href="/feedsetup/formcode_manager/<?=$rows->widgetkey?>" class="dashboard-button blue">Integrate</a>
                </div>
            <?php 
            endforeach;
            endif; 
            ?>
            </div>
        </div>
        <div class="dashboard-foot"></div>
    </div>
</div>