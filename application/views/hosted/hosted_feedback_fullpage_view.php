<script type="text/javascript">
		
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
		$('#append').click(function(){
			add_boxes();		
		});
		
		$(window).scroll(function() {
		   if($(window).scrollTop() + $(window).height() == $(document).height()) {
				//add_boxes();		 
		   }
		});
	});
	/* end of document ready function. below are custom functions for this form */	
	function add_boxes(){
		var $container = $('#theFeedbacks');
		/* ajax here */
		var $boxes = $('<div class="feedback featured">'+
								'<div class="feedbackContents">'+
									'<div class="feedbackBlock">'+
										'<div class="feedbackAuthor">'+
											'<div class="feedbackAuthorAvatar"><img src="images/enna.png" width="48" height="48" /></div>'+
											'<div class="feedbackAuthorDetails">'+
												'<h2>Enna Serrano</h2>'+
												'<h4>Marketing Manager, <span>Davis LLP</span></h4>'+
												'<p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>'+
												'<p><span class="feedbackDate">26th April 2012</span></p>'+
											'</div>'+
										'</div>'+
										'<div class="feedbackText">'+
											'<div class="feedbackTextTail"></div>'+
											'<div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div class="feedbackBlock">'+
										'<div class="feedbackMeta">21 minutes ago via <a href="#">36Stories</a></div>'+
									'</div>'+
								'</div>'+
							'</div>'+'<div class="feedback normal">'+
								'<div class="feedbackContents">'+
									'<div class="feedbackBlock">'+
										'<div class="feedbackAuthor">'+
											'<div class="feedbackAuthorAvatar"><img src="images/enna.png" width="48" height="48" /></div>'+
											'<div class="feedbackAuthorDetails">'+
												'<h2>Enna Serrano</h2>'+
												'<h4>Marketing Manager, <span>Davis LLP</span></h4>'+
												'<p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>'+
												'<p><span class="feedbackDate">26th April 2012</span></p>'+
											'</div>'+
										'</div>'+
										'<div class="feedbackText">'+
											'<div class="feedbackTextTail"></div>'+
											'<div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p><p>I had great fun using your product. </p>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div class="feedbackBlock">'+
										'<div class="feedbackMeta">21 minutes ago via <a href="#">36Stories</a></div>'+
									'</div>'+
								'</div>'+
							'</div>'+'<div class="feedback normal">'+
								'<div class="feedbackContents">'+
									'<div class="feedbackBlock">'+
										'<div class="feedbackAuthor">'+
											'<div class="feedbackAuthorAvatar"><img src="images/enna.png" width="48" height="48" /></div>'+
											'<div class="feedbackAuthorDetails">'+
												'<h2>Enna Serrano</h2>'+
												'<h4>Marketing Manager, <span>Davis LLP</span></h4>'+
												'<p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>'+
												'<p><span class="feedbackDate">26th April 2012</span></p>'+
											'</div>'+
										'</div>'+
										'<div class="feedbackText">'+
											'<div class="feedbackTextTail"></div>'+
											'<div class="feedbackTextBubble"><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p><p>I had great fun using your product.  Its more comfortable to use than your competitor.Constantly surprising your customers!</p><p>Constantly surprising your customers!</p><p>Constantly surprising your customers!</p>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div class="feedbackBlock">'+
										'<div class="feedbackMeta">21 minutes ago via <a href="#">36Stories</a></div>'+
									'</div>'+
								'</div>'+
							'</div>'+'<div class="feedback normal">'+
								'<div class="feedbackContents">'+
									'<div class="feedbackBlock">'+
										'<div class="feedbackAuthor">'+
											'<div class="feedbackAuthorAvatar"><img src="images/enna.png" width="48" height="48" /></div>'+
											'<div class="feedbackAuthorDetails">'+
												'<h2>Enna Serrano</h2>'+
												'<h4>Marketing Manager, <span>Davis LLP</span></h4>'+
												'<p><span style="float:left;">New York, USA</span><span class="flag flag-ph"></span></p>'+
												'<p><span class="feedbackDate">26th April 2012</span></p>'+
											'</div>'+
										'</div>'+
										'<div class="feedbackText">'+
											'<div class="feedbackTextTail"></div>'+
											'<div class="feedbackTextBubble"><p>I had great fun using your product.</p>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div class="feedbackBlock">'+
										'<div class="feedbackMeta">21 minutes ago via <a href="#">36Stories</a></div>'+
									'</div>'+
								'</div>'+
							'</div>');
			$container.append( $boxes ).masonry( 'appended', $boxes ); 
	}
 
 function loadSocialButtons(id,target){
		
		var link = 'http://www.36stories.com/stand-alone/'+id;
		if(target.find('.twitter-button').length == 0){
			target.append(
						$('<div />').addClass('twitter-button')
									.append('<a href="'+link+'" class="twitter-share-button">Tweet</a>'))
				  .append(
						$('<div />').addClass('facebook-button')
									.append('<iframe src="//www.facebook.com/plugins/like.php?href='+link+'&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>')
				  );
			
			twttr.widgets.load(); // parse the twitter widgets
			FB.XFBML.parse();	  // parse the facebook widgets
		}
		target.slideToggle('fast');
	}

</script>

<div id="headerWrapper">
	<div id="headerContent">
    	<div id="headerTitle">
            <?$company_name = ucfirst($company->name);?>

        	<strong><?=$company_name?></strong>  
            <span><?=HTML::link('/', 'View all feedback')?></span>
            
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
                    <?=HTML::image('img/company_logos/'.$company->logo)?>
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
    </div>
</div>
