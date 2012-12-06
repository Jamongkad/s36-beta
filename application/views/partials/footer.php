<?if(S36Auth::check()):?> 
    <?=View::make('partials/admin_sorter_bar')?>
        </div> 
        <div class="c"></div>
    </div>
    <div id="footer">
        <h4>Feedback & Customer Satisfaction Simplified.</h4>
        <h4>36Stories © 2011. </h4>
        <p>Keep in touch by following us on <a href="#">Facebook</a>, <a href="#">Twitter</a>, subscribing to our <a href="#">blog's feed</a> and joining our <a href="#">email newsletter</a>.</p>
    </div>
    <?if(Config::get('application.env_name') == 'prod'):?>
        <script type="text/javascript">
            var widgetId = 'i1ghz';
            var host = (("https:" == document.location.protocol) ? "https://secure." : "http://");
            document.write(unescape("%3Cscript src='" + host + "feedback.36storiesapp.com/widget/js_output?widgetId="+widgetId+"' type='text/javascript'%3E%3C/script%3E"));
        </script>                     
    <?endif?>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>

<?=HTML::script('js/jquery.validate.js')?>
<?=HTML::script('js/jquery.formbuilder.js')?>

<?=HTML::script('js/inbox/services/SettingsService.js')?>

<?=HTML::script('js/inbox/directives/Components.js')?>
<?=HTML::script('js/inbox/directives/myreply.js')?>
<?=HTML::script('js/inbox/directives/myrequest.js')?>
<?=HTML::script('js/inbox/directives/myformbuilder.js')?>

<?=HTML::script('js/inbox/controllers/SettingReplyCtrl.js')?>
<?=HTML::script('js/inbox/controllers/requestctrl.js')?>
<?=HTML::script('js/inbox/controllers/replyctrl.js')?>

<?=HTML::script('js/inbox/S36InboxModule.js')?>
<?=HTML::script('js/jquery.flot.js')?>
<?=HTML::script('js/jquery.flot.pie.js')?>

<?=HTML::script('js/head.min.js')?>
<?
    $js_scripts = Array(
       '/js/jquery.switcharoo.js'
     , '/js/jquery.fancytips.js'
     , '/js/jquery.form.js'
     , '/js/jquery.tmpl.js'
     , '/js/jquery.jcrop.js'
     , '/js/jquery.ajaxfileupload.js' 
     , '/js/jquery.zclip.js' 
     , '/js/jquery.pjax.js'
     , '/js/inbox/s36LightBox.js'
     , '/js/inbox/ZClip.js'
     , '/js/inbox/Checky.js'
     , '/js/inbox/DropDownChange.js'
     , '/js/inbox/InboxStatusChange.js'
     , '/js/inbox/InboxFilters.js'
     , '/js/inbox/FeedSetup.js'
     , '/js/inbox/Status.js'
     , '/js/inbox/Settings.js'
     , '/js/inbox/s36application.js'
   );
?> 
<script text="text/javascript">
    <?foreach($js_scripts as $scripts):?>
       head.js('<?=$scripts?>');
    <?endforeach?>
</script>

<?endif?>

</div>

<div id="notification">
	<div id="notification-design">
    	<div id="notification-message" style="display:none">
        	Loading... Please Wait...
        </div>
    </div>
</div>
</body>
</html>
