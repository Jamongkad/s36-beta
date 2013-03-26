<?=HTML::style('css/widget_master/hosted-form.css');?>
<?//=$company_header?>
<?//=$widget?>
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
<style type="text/css">
#fb-false-connect{
    background:url(/img/fb-connect-success.jpg) no-repeat;
    width:165px;
    height:22px;
    cursor:pointer;
    margin:0 auto;
}
#step_2,#step_3,#step_4,#step_5,#step_6,#step_7{
    display:none;
}

#edited-textarea {     
    background:#f7f7f7;
    border:1px solid #e1e1e1;
    padding:10px;
    width:360px;
    height:110px;
    font-family:Arial, Helvetica, sans-serif;
}

#submission-loader {
    text-align:center; margin:0 auto
}

#submission-success {
    line-height:22px;
}
</style>
<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>

<div id="fb-root"></div>

<div id="bodyWrapper">
	<div id="bodyContent" ng-app="Form">
        <div id="feedbackBox">
        	<div class="block">
            	<div id="s36_pages">
                    <div id="steps">
                        <div class="s36_pages">
                            <ng-view></ng-view>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
