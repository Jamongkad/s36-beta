<title><?=ucfirst($company->company_name);?> - Customer's Stories</title>
<?=HTML::style('css/widget_master/hosted-fullpage.css');?>
<?if($hosted):?>
    <?=HTML::style('themes/hosted/fullpage/fullpage-'.$hosted->theme_type.'.css');?>
<?endif?>

<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<script type="text/javascript">
	var counter = 0;	
	$(document).ready(function(){
		$('#theFeedbacks').masonry({
			itemSelector: '.feedback',
			columnWidth: 100,
			isAnimated: !Modernizr.csstransitions,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			  }
		});
		
		$(window).scroll(function() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
                counter += 1;
				add_boxes(counter);		 
		   }
		});

        $(document).delegate(".feedbackAuthorAvatar", "hover", function(e) {
            if (e.type === "mouseenter")  {
                $('img.large-avatar', this).show();
            } else { 
                $('img.large-avatar', this).hide();
            }
        });

        $('.feedback').hover(function(){
            $(this).find('.feedbackSocialTwitter').fadeIn();
            $(this).find('.feedbackSocialFacebook').fadeIn();
            $(this).find('.feedbackSocialView').fadeIn();
        },function(){
            $(this).find('.feedbackSocialTwitter').fadeOut();
            $(this).find('.feedbackSocialFacebook').fadeOut();
            $(this).find('.feedbackSocialView').fadeOut();
        });
	});

	/* end of document ready function. below are custom functions for this form */	
	function add_boxes(counter){

		var container = $('#theFeedbacks');
        var page_counter = counter + 1;

        $.ajax({
              url: '/hosted/fullpage_partial/<?=strtolower($company->company_name)?>/' + page_counter
            , success: function(msg) {
 		        var boxes = $(msg);               
         		container.append( boxes ).masonry( 'appended', boxes ); 
                FB.XFBML.parse();
                twttr.widgets.load();

                $('.feedback').hover(function(){
                    $(this).find('.feedbackSocialTwitter').fadeIn();
                    $(this).find('.feedbackSocialFacebook').fadeIn();
                },function(){
                    $(this).find('.feedbackSocialTwitter').fadeOut();
                    $(this).find('.feedbackSocialFacebook').fadeOut();
                });
            }
        });

	}
</script>

<?=View::make('hosted/partials/hosted_feedback_header_view', Array(
       'company_name' => $company->company_name
     , 'hostname' => $hostname
     , 'deploy_env' => $deploy_env
     , 'domain' => $company->domain 
))?>

<div id="bodyWrapper">
    <div id="bodyContent">
        <div id="pageTitle">
            <div class="grids">
                <div class="g4of5">
                    <?if($hosted):?>
                        <h1><?=$hosted->header_text?></h1>
                    <?else:?>
                        <h1>Hear what our customers have to say</h1>
                    <?endif?>
                </div>
                <div class="g1of5" align="right"> 
                    
                </div>
            </div>
        </div>
        <!--
        <div id="companyDetails" class="block">
            <div class="companyLinks">
                <?if($company->social_links):?> 
                    <ul>
                        <li><a href="#" class="website">Visit Our Website</a></li>
                        <li><a href="#" class="facebook">Join us on Facebook</a></li>
                        <li><a href="#" class="twitter">Follow us on Twitter</a></li>
                    </ul>
                <?else:?>
                    <ul>
                        <li><a href="#" class="website">Visit Our Website</a></li>
                        <li><a href="#" class="facebook">Join us on Facebook</a></li>
                        <li><a href="#" class="twitter">Follow us on Twitter</a></li>
                    </ul>
                <?endif?>
            </div>
        </div>
        -->
            <!--this is where the magic starts-->
            <div id="theFeedbacks">
                <?=$feeds?> 
            </div>
            <!--this is where the magic starts-->
        </div>

        <div class="block" style="height:40px;"></div>
        <div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
    </div>
</div>
