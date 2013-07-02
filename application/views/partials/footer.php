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

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>

<?=HTML::script('/admin_dashboard/services/SettingsService.js')?>

<?=HTML::script('/admin_dashboard/directives/Components.js')?>
<?=HTML::script('/admin_dashboard/directives/myreply.js')?>
<?=HTML::script('/admin_dashboard/directives/myrequest.js')?>
<?=HTML::script('/admin_dashboard/directives/myfeedbackcount.js')?>
<?=HTML::script('/admin_dashboard/directives/myformbuilder.js')?>

<?=HTML::script('/admin_dashboard/controllers/feedbackcontrol.js')?>
<?=HTML::script('/admin_dashboard/controllers/mainreplyctrl.js')?>
<?=HTML::script('/admin_dashboard/controllers/mainrequestctrl.js')?>
<?=HTML::script('/admin_dashboard/controllers/SettingReplyCtrl.js')?>

<?=HTML::script('/admin_dashboard/S36InboxModule.js')?>
<?=HTML::script('js/jquery.validate.js')?>
<?=HTML::script('js/jquery.serializeform.js')?>
<?=HTML::script('js/jquery.formbuilder.js')?>
<?=HTML::script('js/head.min.js')?>
<script text="text/javascript">
   head.js('/js/jquery.form.js');
   head.js('/js/inbox/Status.js');
</script>
</body>
</html>