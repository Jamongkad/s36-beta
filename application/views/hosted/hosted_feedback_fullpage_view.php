<title><?=ucfirst($company->name);?> - Customer's Stories</title>

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
                $('.large-avatar', this).show();
            } else { 
                $('.large-avatar', this).hide();
            }
        });

        $('.feedback').hover(function(){
            $(this).find('.feedbackSocialTwitter').fadeIn();
            $(this).find('.feedbackSocialFacebook').fadeIn();
        },function(){
            $(this).find('.feedbackSocialTwitter').fadeOut();
            $(this).find('.feedbackSocialFacebook').fadeOut();
        });
	});
	/* end of document ready function. below are custom functions for this form */	

	function add_boxes(counter){

		var container = $('#theFeedbacks');
        var page_counter = counter + 1;
        $.ajax({
              url: '/hosted/fullpage_partial/<?=$company->companyid?>/' + page_counter
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

<div id="headerWrapper">
	<div id="headerContent">
    	<div id="headerTitle">
            <?$company_name = ucfirst($company->name);?>
        	<strong><?=$company_name?></strong>              
            <span><?=HTML::link('/', 'Send in feedback')?></span>

            <?if($company->domain):?>
                <span class="right padfix">
                    <a href="http://<?=$company->domain?>" target="_blank"><?="Visit $company_name's Website"?></a>
                </span>
            <?endif?>
        </div>
    </div>
</div>
<div id="bodyWrapper">
    <div id="bodyContent">
        <div id="companyDetails" class="block">
        	<div class="companyLogo">
                <?if($company->logo):?>
                    <?=HTML::image('company_logos/'.$company->logo)?>
                <?else:?>
                    <?=HTML::image('img/company-logo-filler.jpg')?>
                <?endif?>
            </div>
            <div class="companyDetails">
            	<h2>Company Profile</h2>
                <p>
                    <?if($company->description):?>
                        <?=$company->description?> 
                    <?else:?>
                        Acme in specializes in creating widgets for everyday use. Thousands of 
                        customers worldwideuse Acme products and get better each and everyday. 
                        Visit Acme's website today for more information. 
                    <?endif?>
                </p>

				<br />
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
        </div>
            <div id="theFeedbacks">
                <?=$feeds?> 
            </div>
        </div>

        <div class="block" style="height:40px;"></div>
        <div class="block" style="text-align:center;font-size:11px;color:#c2c3c4;">Powered by 36Stories</div>
    </div>
</div>
