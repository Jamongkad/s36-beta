                   <div class="ultra-awesome-spacer"></div>
               </div> <!-- end of #theDashboardContents -->
            </div> <!-- end of #theDashboard -->
        </div> <!-- end of #mainContainer -->
    </div> <!-- end of #fadedContainer -->
</div> <!-- end of #mainWrapper -->

<?=HTML::script('/fullpage/admin/js/Settings.js')?>
<?=HTML::script('/fullpage/admin/js/SettingsAutoSaver.js')?>
<script type="text/javascript">
	$(document).ready(function(){
		Settings.init();
	  SettingsAutoSaver.init();
	});
</script>
<?php
/*
|--------------------------------------------------------------------------
| FancyBox
|--------------------------------------------------------------------------
*/
echo HTML::script('/fancybox/jquery.fancybox.js');
echo HTML::script('/fancybox/jquery.fancybox.pack.js');
echo HTML::script('/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5');
echo HTML::script('/fancybox/helpers/jquery.fancybox-media.js?v=1.0.5');
echo HTML::script('/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7');
echo HTML::style('/fancybox/jquery.fancybox.css');
echo HTML::style('/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5');
echo HTML::style('/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5');
?>
<?=HTML::script('/admin_dashboard/services/feedbackcontrolservice.js')?>
<?=HTML::script('/admin_dashboard/services/publictemplate.js')?>
<?=HTML::script('/admin_dashboard/services/modifyfeedback.js')?>
<?=HTML::script('/admin_dashboard/services/message.js')?>
<?=HTML::script('/admin_dashboard/services/feedbacksignal.js')?>
<?=HTML::script('/admin_dashboard/services/category.js')?>

<?=HTML::script('/admin_dashboard/directives/Components.js')?>
<?=HTML::script('/admin_dashboard/directives/myreply.js')?>
<?=HTML::script('/admin_dashboard/directives/myfeedbackcount.js')?>
<?=HTML::script('/admin_dashboard/directives/myformbuilder.js')?>
<?=HTML::script('/admin_dashboard/directives/myfeedbackcontrol.js')?>
<?=HTML::script('/admin_dashboard/directives/mymodifyfeedback.js')?>
<?=HTML::script('/admin_dashboard/directives/mycategorycontrol.js')?>

<?=HTML::script('/admin_dashboard/controllers/feedbackcontrol.js')?>
<?=HTML::script('/admin_dashboard/controllers/mainreplyctrl.js')?>
<?=HTML::script('/admin_dashboard/controllers/settingreplyctrl.js')?>
<?=HTML::script('/admin_dashboard/controllers/modifyfeedbackcontrol.js')?>
<?=HTML::script('/admin_dashboard/controllers/settingctgyctrl.js')?>

<?=HTML::script('/admin_dashboard/S36InboxModule.js')?>

<?=HTML::script('/js/jquery.validate.js'); ?>
<?=HTML::script('/js/jquery.serializeform.js'); ?>

<?=HTML::script('/js/jquery.form.js'); ?>
<?=HTML::script('/js/jquery.tmpl.js'); ?>
<?=HTML::script('js/jquery.serializeform.js')?>
<?=HTML::script('js/jquery.formbuilder.js')?>
<?=HTML::script('js/head.min.js')?>
<script text="text/javascript">
   head.js('/js/jquery.form.js');
   head.js('/admin_dashboard/Settings.js');
</script>
</body>
</html>
