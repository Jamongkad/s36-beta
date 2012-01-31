<script type="text/javascript">
	$(document).ready(function(){

		$('.back').click(function(){
			$('.boxSolo').hide();
			$('#feedContainer').fadeIn();
			$('.pagination').show();
			$('#pager').fadeIn();
		});

		$('.readmore, .feedbackText').click(function(){
			
			var id = $(this).attr('feed-id');
			var text = $('#'+id).val();
			var avatar = $(this).parent().parent().find('.feedbackAvatar img').attr('src');
			var name = $(this).parent().parent().find('.feedbackAuthorName').html();
			var position = $(this).parent().parent().find('.authorPosition').html();
			var company = $(this).parent().parent().find('.authorCompany').html();
			var city = $(this).parent().parent().find('.authorCity').html(); 
			var country = $(this).parent().parent().find('.authorCountry').html(); 
			var date =$(this).parent().parent().find('.feedbackDate').html(); 
			var flag =$(this).parent().parent().find('.feedbackAvatar .flag').attr('class'); 
			
			$('.boxSolo').fadeIn();
			$('#feedContainer').hide();
			$('.pagination').hide();
			$('.theSocialButtons').hide();
			
			$('.boxSolo .feedbackText').html('<p>'+text+'</p>').jScrollPane();	
			$('.boxSolo .feedbackAvatar').find('img').attr('src',avatar);
			$('.boxSolo .feedbackAuthorInfo').find('.name').html(name);
			$('.boxSolo .feedbackAuthorInfo').find('.position').html(position);
			$('.boxSolo .feedbackAuthorInfo').find('.company').html(company);
			$('.boxSolo .feedbackAuthorInfo').find('.city').html(city+" ");
			$('.boxSolo .feedbackAuthorInfo').find('.country').html(country);
			$('.boxSolo .feedbackAuthorInfo').find('.date').html(date);
			$('.boxSolo .feedbackAuthorInfo').find('.flag').removeClass().addClass(flag);
			
			$('#pager').hide();
		});

		if($('.feedbacks').length == 1){
			$('.feedbacks').show();
		}
		$('.boxSolo').hide();
		$('.theSocialButtons').hide();
		$('.share').hide();
		$('.feedback').hover(function(){
			$(this).find('.share').fadeIn('fast');
		},function(){
			$(this).find('.share').fadeOut('fast');
			$(this).find('.theSocialButtons').fadeOut('fast');
		});
		
		$('.share').click(function(){
			var social_box = $(this).parent().parent().parent().find('.theSocialButtons');
			var feedback_id = $(this).attr('id');	
			loadSocialButtons(feedback_id,social_box);			
		});		

		$('#slides').cycle({
				fx:      'scrollHorz', 
				speed:   '500', 
				timeout: '5000',
				pause : 1,
				prev : '#prev',
				next : '#next',
				before: beforeCycle, // this hides visible social buttons before a transition is made
				after: showOverFlow		   // this displays the overflow of a feedback div to display the like button's iframe
		});

		$('#slides').mousewheel(function(event,delta){
			if (delta > 0){
                $('#slides').cycle('prev');
            }else{
                $('#slides').cycle('next');
            }
			return false;
		});
		
		$('#sendfeedback').click(function(){
			parent.s36_openForm('1','1','http://dev.gearfish.com/widget/form?siteId=1&companyId=1&themeId=1');	
		});
	});
	
	/* ----------------  end of document ready function  --------------------------*/
	
	function loadSocialButtons(id,target){
		var link = 'http://www.36stories.com/stand-alone/'+id;
		if(target.find('.twitter-button').length == 0){
			target.append(
						$('<div />').addClass('twitter-button')
									.append('<a href="'+link+'" class="twitter-share-button">Tweet</a>'))
				  .append(
						$('<div />').addClass('facebook-button')
									.append('<iframe src="//www.facebook.com/plugins/like.php?href&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154673521284687" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>')
				  );
			
			twttr.widgets.load(); // parse the twitter widgets
			FB.XFBML.parse();	  // parse the facebook widgets
		}
		target.slideToggle('fast');
	}
	
	function createPagination(curr,next,opts,fwd){
		var obj 		= $(next);	  
		var curr_count  = obj.index();
		var max_count   = obj.parent().children().length;
		var pager 		= $('.pagination');   // the div where you want the pagination to appear
		var prev  		= $('#prev');		  // element for prev
		var next  		= $('#next');		  // element for next
		
		if(max_count > 5){
			if(curr_count <= 2){ 					 // check if the current slide is on 1 , 2 and 3
				pager.empty();
				for(ctr = 1;ctr <= 5;ctr++){
					pager.append(
						'<a href="javascript:;">'+ctr+'</a>'
					);
				}
			}else if(curr_count >= (max_count - 3)){ // check if the current slide is on the last 3 slides
				pager.empty();
				for(ctr = (max_count - 4);ctr <= max_count;ctr++){
					pager.append('<a href="javascript:;">'+ctr+'</a>');
				}
			}else{									// generate an awesome custom pagination gadamit
				pager.empty();
				pager.append('<a href="javascript:;">'+(curr_count - 1)+'</a>')
					 .append('<a href="javascript:;">'+(curr_count)+'</a>')
					 .append('<a href="javascript:;">'+(curr_count + 1)+'</a>')
					 .append('<a href="javascript:;">'+(curr_count + 2)+'</a>')
					 .append('<a href="javascript:;">'+(curr_count + 3)+'</a>');
			}
		}else{
			pager.empty();
			for(ctr = 1;ctr <= max_count;ctr++){
				pager.append(
					'<a href="javascript:;">'+ctr+'</a>'
				);
			}
		}
		
		if(curr_count == 0){
			prev.fadeOut();
		}else{
			prev.fadeIn();
		}
		if(curr_count == max_count - 1){
			next.fadeOut();
		}else{
			next.fadeIn();
		}
		// assign a click to each of the paginations
		$('.pagination a').each(function(e){
			var page = parseInt($(this).text());
				if(curr_count == (page-1)){
					$(this).addClass('activeSlide');
				}
			$(this).click(function(){
				$('#slides').cycle((page - 1));
			});
		});

	}
	
	function beforeCycle(curr,next,opts,fwd){
		hideSocialButtons();
		createPagination(curr,next,opts,fwd);
	}
	function hideSocialButtons(){
		$('.theSocialButtons').hide('fast');			
	}
	function showOverFlow(){
		$('.feedBoxes').css('overflow','visible');
	}
	function adjustHeight(curr, next, opts, fwd) {
		var $ht = $(this).height();
		$(this).parent().animate({height: $ht},500);
	}
			
</script>
</head>
<style type="text/css">
	#box{
		margin:0 auto;
		/* margin-top:100px; */
		width:760px;
		height:298px;
		-webkit-border-radius:5px;
		-moz-border-radius:5px;
		border-radius:5px;
		border:1px dashed #DDD;
	}
	.boxPad{
		padding:20px;
		
	}
		.boxHeader{
			display:block;
			overflow:hidden;
		}
		.boxTitle{
			font-size:18px;
			font-weight:bold;
			color:#72777a;
			text-align:left;
			width:70%;float:left;
			padding-top:4px;
		}
		.boxBorder{
			background:url(/img/border.png) repeat-x;
			height:7px;
			display:block;
			margin: 2px 0px;
		}
		.boxFooter{
			text-align:center;
			color:#d8d8d8;
			font-size:10px;
			position:absolute;
			bottom:4px;
			display:block;
			width:720px;
		}
		.footerText{position:absolute;right:21px;bottom:4px;font-size:11px;color:#d8d8d8}
		.boxOptions{
			width:30%;
			float:left;
			padding-bottom:10px;
		}
			.sendFeedback{float:left;width:50%;padding-top:7px;font-weight:bold;}
				.sendFeedback a{color:#6c6c6c;text-decoration:underline;font-size:11px;}
			.viewAll{float:left;width:50%;text-align:right;}
				.viewAllBtn{background:url(/img/viewallbtn.png) no-repeat;background-position:top;width:96px;height:27px;border:none;cursor:pointer;}
				.viewAllBtn:hover{background-position:bottom;}
			
			.pagination{text-align:center;font-size:11px;padding:0px 0px;margin-bottom:3px;overflow:hidden}
			.pagination a{padding:2px 3px;color:#929191;text-decoration:none;}
			.pagination a.activeSlide{background:#72abe0;color:#FFF;}
				#prev,#next{cursor:pointer;}
				#prev:hover,#next:hover{color:#72abe0;}
		.feedContainer{height:200px}	
		.feedBoxes{
			margin:15px 0px 5px;
		}
			.boxSolo, .feedbacks{
				padding-top:0px;
			}
			.feedbacks{
				display:none;
			}
			.boxSolo .feedback{
				display:block;
				height:175px;
				margin:0 auto;
				width:720px;
				padding-top:10px;
			}
			.feedbacks .feedback{
				display:block;
				height:190px;
				width:210px;
				float:left;
			}
			.feedback.mid{
				margin: 0px 42px;
			}
				
				/* multiple feedbacks width adjust */
				.feedBoxes .feedbackAvatar{
					width:50px;float:left;
				}
				.feedBoxes .feedbackAvatar img{border:1px solid #e7e7e7;}
				.feedBoxes .feedbackInfo{
					margin-left:10px;
					width:150px;
					float:left;
					height:55px;
				}
				/* end of multiple feedbacks */	
				
				/* solo feedback width adjust */
				.boxSolo .feedbackAvatar{
					width:50px;float:left;text-align:center;
				}
				.boxSolo .feedbackAvatar img{border:1px solid #e7e7e7;margin-bottom:15px;}
				.boxSolo .feedbackInfo{
					margin-left:10px;
					width:660px;
					float:left;
					
				}	
				/* end of solo width adjust */
				.feedbackAuthor{margin-bottom:10px;}	 
					 .feedbackAuthorName{color:#5f5f61;font-size:12px;font-weight:bold;margin-bottom:3px;}
					 .feedbackAuthorInfo{font-size:11px;margin-bottom:3px;}
					 .feedbackAuthorInfo span{float:left;}
						 .authorPosition{color:#72777a;}
						 .authorCompany{color:#b4b4b4;text-decoration:underline;}
				
					 .feedbackAuthorLocation{font-size:10px;color:#747474;}
					 .feedbackAuthorLocation span{float:left;}
					 .feedbacks .feedbackText{color:#969696;font-size:13px;text-align:justify;margin-bottom:5px;word-wrap:break-word;line-height:17px;height:106px;overflow:hidden;cursor:pointer;}	
					 .feedbacks .feedbackText .theText{display:block}
				
					 .feedbacks .theSocialButtons{background:#f3f3f3;padding:6px 8px;border:1px solid #e4e4e4;position:absolute;bottom:18px;left:0px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
								.theSocialButtons .shareTail{background:url(/img/share-arrow.png) no-repeat;width:11px;height:7px;position:absolute;bottom:-7px;left:3px;}
								
								a.share{padding-left:16px;background:url(/img/ico-share.png) no-repeat left top;margin-left:4px;}
								a.share:hover{color:#88bae8;background-position:left bottom;}
								
					 .boxSolo .feedbackText{color:#969696;font-size:13px;margin:10px 0px;word-wrap:break-word;line-height:18px;height:144px;}	
					 .boxSolo .feedbackText p{margin-bottom:15px;}
				
					 .feedbacks .feedbackOptions{font-size:11px;}	
				
					 .boxSolo .feedbackOptions{font-size:11px;}
						 .feedbackOptions .feedbackReadMore{float:left;width:40%;}
						 .feedbackOptions .feedbackReadMore a{color:#919191;text-decoration:none;font-size:10px;}
						 .feedbackOptions .feedbackDate{float:left;width:60%;color:#919191;font-size:10px;text-align:right;}
				
				.boxSolo .feedbackAuthorInfo{margin-bottom:1px;}
						 .feedbackAuthorInfo .name{color:#5f5f61;font-size:12px;font-weight:bold;}
						 .feedbackAuthorInfo .position{color:#777779;font-size:11px;padding-left:4px;}
						 .feedbackAuthorInfo .company{color:#b3b6bd;font-size:11px;text-decoration:underline;}
						 .feedbackAuthorInfo .city{padding-left:4px;font-size:10px;color:#757678;}
						 .feedbackAuthorInfo .country{font-size:10px;color:#757678;}						 						 						 
				
				.boxSolo .feedbackSocial{width:500px;float:left;}						 
				
				.boxSolo .feedbackReturnDate{float:left;width:160px;text-align:right;padding-top:3px;}
				.boxSolo .feedbackAvatar .back{padding-left:7px;background:url(/img/ico-back.png) left center no-repeat;color:#919191;text-decoration:none;}
				.boxSolo .feedbackAvatar .back a{color:#88bae8;text-decoration:none;}
				.boxSolo .feedbackAvatar .back a:hover{color:#90c2ef;}
						 .feedbackAuthorInfo .date{padding-left:7px;color:#babbbd;float:right;}
				
				.boxFooter:after,.feedbackOptions:after,.feedbackAuthorInfo:after,.feedbacks:after,.feedbackSocial:after,.feedbackAuthor:after,.theSocialButtons:after,.feedbackAuthorLocation:after{content: ".";display: block;height: 0;clear: both;visibility: hidden;}
				
				.twitter-button{margin-top:0px;float:left;width:80px;}
				.facebook-button{float:left;width:80px;}
				
				
				.fb_send_button_form_widget{top:-198px !important;}
				.fb_edge_comment_widget{top:-198px !important;}
				
</style>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=154673521284687";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="box">
	<div class="boxPad">
    	<div class="boxHeader">
          	 <div class="boxTitle">
            	What some of our customers say
             </div>
             <div class="boxOptions">
                <div class="sendFeedback">
                    <a href="javascript:;" id="sendfeedback">Send Feedback</a>
                </div>
                <div class="viewAll">
                    <input type="button" class="viewAllBtn" value="" />
                </div>
            </div>
        </div>
        <div class="boxBorder"></div>

        <div class="boxSolo" style="display:none;">
        	<div class="feedback">
                <div class="feedbackAvatar">
                    <img src="images/blank2.jpg" />
                    <span class="back"><a href="javascript:;">back</a> </span>
                </div>
                <div class="feedbackInfo">
                    <div class="feedbackAuthorInfo">
                    	<span class="name"></span>
                    	<span class="position"></span>
                        <span class="company"></span> 
                        <span class="city"></span>
                        <span class="country"></span>
                        <span class="flag flag-ph"></span>
                        <span class="date"></span>
                    </div>
                    <div class="feedbackText">
                    </div>
                    <div class="feedbackOptions">
                        <div class="feedbackSocial">
                        	
                            <!-- twitter widget -->
                            
                            <div class="twitter-button">
                                <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </div>
                            
                            <div class="facebook-button">
                            <!-- like button -->
                            	<div class="fb-like" data-href="http://webmumu.com" data-send="true" data-width="450" data-show-faces="false"></div>
                            </div>                            
                            
                        </div>
                        <div class="feedbackReturnDate">
                            <!-- <span class="back"><a href="javascript:;">back</a> </span> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?//Helpers::show_data($data->result);?>
        <div id="feedContainer">
            <div id="slides" class="feedBoxes">
                <!-- group -->
                <?php
					$ctr = 0;
                    $units = 3;
                    $max = $row_count;
                    Helpers::show_data($result[0]->rules->displayname);
					foreach($result as $r): 
                    /*                        
                        print_r($r->rules);
						if(($ctr % $units) == 0){
							echo '<div class="feedbacks">';
							$end = 1;
						}
						if($end == 2){
							$feedback_class = "feedback mid";
						}else{
							$feedback_class = "feedback";
						}
							//avatar
							$avatar = trim($r->avatar);
							if($avatar == ''){
                                $avatar = "/img/48x48-blank-avatar.jpg";
							}else{
								$avatar = "/uploaded_cropped/48x48/".$avatar;
							}
							//country code for the class
							$cc 	= strtolower($r->countrycode);
							//date
							if(trim($r->date) != ""){
								$date 	= '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
							}else{
								$date	= '';
							}
							
							//check if name is available:
							if((trim($r->firstname) != "")){
								
								$name = $r->firstname.' '.$r->lastname;
								
							}else{
								
								$name = '';
								
							}
							
							//check if position is available:
							if((trim($r->companyname) != "") && (trim($r->position) != "")){
								
								$comp = '<div class="position">'.$r->position.', '.$r->companyname.'</div>';
								
							}else if((trim($r->companyname) == "") && (trim($r->position) != "")){
								
								$comp = '<div class="position">'.$r->companyname.'</div>';
								
							}else if((trim($r->companyname) != "") && (trim($r->position) == "")){
								
								$comp = '<div class="position">'.$r->position.'</div>';
								
							}else{
								
								$comp = '';
								
							}
							
							//check if the feedback has 100 chars or more
							$maxchars = 100;
							if(strlen(trim($r->text)) <= $maxchars){
								$text = substr($r->text,0,$maxchars) . ' <br />';								
							}else{
								$text = $r->text . '<span style="color:#88bae8;font-size:10px;">(read full feedback)</span>';
							}
							
							   echo '<div class="'.$feedback_class.'"><input type="hidden" value="'.$r->text.'" id="'.$r->id.'" />
										<div class="feedbackAuthor">
											<div class="feedbackAvatar">
												<img src="'.$avatar.'" />
												<span class="flag flag-'.strtolower($r->countrycode).'"></span>
											</div>
											<div class="feedbackInfo">
												<div class="feedbackAuthorName">'.$name.'</div>
												<div class="feedbackAuthorInfo">
													<span class="authorPosition">'.$r->position.'</span> 
													<span class="authorCompany">'.$r->companyname.'</span>
												</div>
												<div class="feedbackAuthorLocation">
													<span class="authorCity">'.$r->city.', </span>
													<span class="authorCountry"> '.$r->countryname.'</span>													
												</div>
											</div>
										</div>
										<div>    
											<div class="feedbackText" feed-id="'.$r->id.'">
												<div class="theText" >'.$text.' </div>
											</div>
											<div class="feedbackOptions">
												<div class="feedbackReadMore">
													<a href="javascript:;" id="4" class="share">&nbsp;</a>
													&nbsp;
												</div>
												<div class="feedbackDate">
													'.$date.'
												</div>
											</div>
											<div class="theSocialButtons">
											   
												<div class="shareTail"></div>
											</div>
										</div>
									</div>';
						if(($end == $units) || $ctr == ($max - 1)){
							echo '</div>';
						}
						$end++;
						$ctr++;
                    */
					endforeach;  
				?>
                
               
                <!-- end of group -->
            </div>
        <!-- end of feedboxes -->
        </div>
        <div class="boxFooter">
        	<span id="pager">
                <span id="prev">◄</span>
                <span class="pagination"></span>
                <span id="next">►</span>
            </span>
        </div>
    </div>
    <div class="footerText">
        <span>Powered by 36Stories</span>
    </div>
</div>
