                </div> <!-- end of #theDashboardContents -->
            </div> <!-- end of #theDashboard -->

        </div> <!-- end of #mainContainer -->
    </div> <!-- end of #fadedContainer -->
</div> <!-- end of #mainWrapper -->

</body>
</html>

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

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>

<?=HTML::script('js/inbox/services/SettingsService.js')?>

<?=HTML::script('js/inbox/directives/Components.js')?>
<?=HTML::script('js/inbox/directives/myreply.js')?>
<?=HTML::script('js/inbox/directives/myrequest.js')?>
<?=HTML::script('js/inbox/directives/myfeedbackcount.js')?>
<?=HTML::script('js/inbox/directives/myformbuilder.js')?>

<?=HTML::script('js/inbox/controllers/mainreplyctrl.js')?>
<?=HTML::script('js/inbox/controllers/mainrequestctrl.js')?>
<?=HTML::script('js/inbox/controllers/SettingReplyCtrl.js')?>

<?=HTML::script('js/inbox/S36InboxModule.js')?>
<?=HTML::script('js/head.min.js')?>
