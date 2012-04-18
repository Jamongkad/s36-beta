<script type="text/javascript" src="http://platform.linkedin.com/in.js">

  <?if($env == 'dev' or $env == 'local'):?>
  //DEV API KEY
  api_key: zmekq26qusj2
  <?endif?>

  <?if($env == 'prod'):?>
  //PROD API KEY
  api_key: 1b773lzkdw3f
  <?endif?>
  authorize: true
</script>
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


<body style="background:#000">
<!-- facebook scripts -->
<div id="fb-root"></div>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
  FB.init({appId: '<?=$fb_app_id?>', status: true,
		   cookie: false, xfbml: true});
  FB.Event.subscribe('auth.login', function(response) {
	FB.api('/me', function(user) {
	   if(user != null) {
		  S36Form.fb_connect_success(user);
	   }else{
		  alert('error logging in to facebook');  
	   }
	 });        
  });
</script>
<!-- end of facebook script -->

<!-- 36Stories DataExchange URLs -->
<span id="ajax-upload-url" hrefaction="<?=URL::to('/widget/form/upload')?>"></span>
<span id="ajax-crop-url" hrefaction="<?=URL::to('/widget/form/crop')?>"></span>
<span id="ajax-submit-feedback" hrefaction="<?=URL::to('/api/submit_feedback')?>"></span>
<span id="ajax-step-metrics" hrefaction="<?=URL::to('/api/check_step')?>"></span>
<!-- end of 36Stories script -->
<p>Mathew</p>
