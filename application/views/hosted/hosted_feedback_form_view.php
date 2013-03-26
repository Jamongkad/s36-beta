<?//=HTML::style('css/widget_master/hosted-form.css');?>
<?//=$company_header?>
<?//=$widget?>
<?=HTML::style('css/widget_master/new_form.css');?>
<?=HTML::script('js/jcycle.js');?>
<?=HTML::script('js/jquery.ui.widget.js');?>
<?=HTML::script('js/jquery.iframe-transport.js');?>
<?=HTML::script('js/jquery.fileupload.js');?>
<?=HTML::script('https://cloud.github.com/downloads/bytespider/jsOAuth/jsOAuth-1.3.6.min.js');?>
<?=HTML::script('js/jquery.oauth.js');?>
<!-- file upload js requirements -->
<!-- link preview js -->
<?=HTML::script('js/link.preview.js');?>
<!-- link preview js -->
<!--[if lt IE 8]>
    <script src="js/ie7.js"></script>
<![endif]-->
<div id="formBox" ng-app="Form">
    <ng-view></ng-view>
</div>
<div class="block" style="height:20px;"></div>
<div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
