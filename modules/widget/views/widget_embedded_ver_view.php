<?php
	
	error_reporting(0);
	
	//get the parameters
	$companyId 	= isset($_GET['companyId']) ? $_GET['companyId']	: 1;
	$siteId		= isset($_GET['siteId']) 	? $_GET['siteId'] 		: 2;
	$units		= isset($_GET['units']) 	? $_GET['units']		: 3;
	$transition = isset($_GET['transition'])? $_GET['transition'] 	: 'scrollVert';
	$speed		= isset($_GET['speed']) 	? $_GET['speed']		: 500;
	$timeout	= isset($_GET['timeout']) 	? $_GET['timeout'] 		: 5000;
	$type		= isset($_GET['type']) 		? $_GET['type'] 		: 'horizontal';
	
	// this function will remove the s36_feedback() on the JSON
	function removeJSONfunction($json){
		$json = trim($json);
		$json = str_replace("s36_feedback(","[",$json);
		$json = str_replace("})","}]",$json);
		return $json;
	}
	function getRightClass($units){
		if($units == '1'){
			$class = "g1of1";
		}elseif($units == '2'){
			$class = "g1of2";
		}elseif($units == '3'){
			$class = "g1of3";
		}elseif($units == '4'){
			$class = "g1of4";
		}elseif($units == '5'){
			$class = "g1of5";
		}
		return $class;
	}

	// assign the json url to this var
	//$url = "http://dev.gearfish.com/index.php/api/pull_feedback?company_id=".$companyId."&site_id=".$siteId."&limit=30&offset=0&is_featured=1&is_published=1";
	$url = "http://dev.gearfish.com/api/pull_feedback?company_id=".$companyId."&site_id=".$siteId."&limit=30&offset=0&is_featured=1&is_published=1";
	
	// get the string from the url
	$json = file_get_contents($url);
	
	// remove the json function
	$json = removeJSONfunction($json);
	
	// decode the json. this will turn the strings to an array
	$fb = json_decode($json);
	
	// get the feedbacks
	$result = $fb[0]->result;
	
	// get the maximum feedback returned
	//$max 	= count($result);
	$max 	= $fb[0]->total_rows;
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="master_template.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
<script type="text/javascript" src="js/jquery.scroll.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){

		$('.back').click(function(){
			$('.boxSolo').hide();
			$('#feedContainer').fadeIn();
			$('.pagination').show();
			$('#pager').fadeIn();
		});
		$('.readmore, .feedbackText').click(function(){
			$('.boxSolo').fadeIn();
			$('#feedContainer').hide();
			$('.pagination').hide();
			$('.theSocialButtons').hide();
			$('.boxSolo .feedbackText').jScrollPane();	
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
				fx:      'scrollVert', 
				speed:   '500', 
				timeout: '5000',
				pause : 1,
				prev : '#prev',
				next : '#next',
				before: beforeCycle, // this hides visible social buttons before a transition is made
				after: showOverFlow		   // this displays the overflow of a feedback div to display the like button's iframe
		});

		$('#slides').mousewheel(function(event,delta){
			if (delta > 0){$('#slides').cycle('prev');}
			else{$('#slides').cycle('next');}
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
		margin-top:100px;
		width:250px;
		height:500px;
		-webkit-border-radius:5px;
		-moz-border-radius:5px;
		border-radius:5px;
		border:1px dashed #DDD;
	}
	.boxPad{
		padding:20px;
	}
		.boxTitle{
			font-size:13px;
			font-weight:bold;
			color:#000;
			text-align:center;
			margin-bottom:10px;
		}
		.boxBorder{
			background:url(images/border.png) repeat-x;
			height:7px;
			display:block;
			margin: 2px 0px;
		}
		.footerText{position:absolute;bottom:4px;font-size:11px;color:#d8d8d8;width:200px;text-align:center;left:50%;margin-left:-100px;}
		.boxFooter{
			padding-top:5px;
			text-align:center;
			color:#d8d8d8;
			font-size:10px;
		}
		
		.boxOptions{
			overflow:hidden;
		}
			.sendFeedback{float:left;width:50%;padding-top:7px;font-weight:bold;}
				.sendFeedback a{color:#6c6c6c;text-decoration:underline;font-size:11px;}
			.viewAll{float:left;width:50%;text-align:right;}
				.viewAllBtn{background:url(images/viewallbtn.png) no-repeat;background-position:top;width:96px;height:27px;border:none;cursor:pointer;}
				.viewAllBtn:hover{background-position:bottom;}
			
			.pagination{text-align:center;font-size:11px;padding-top:5px;}
			.pagination a{padding:2px 3px;color:#929191;text-decoration:none;}
			.pagination a.activeSlide{background:#72abe0;color:#FFF;}
			
		.feedBoxes{
			margin-top:15px;
		}
			.boxSolo{
				padding-top:10px;
			}

			.feedbacks .feedback{
				overflow:hidden;
				display:block;
				height:100px;
				margin-bottom:18px;
				cursor:pointer;
			}
			.boxSolo .feedback{
				overflow:hidden;
				display:block;
				height:346px;
				margin-bottom:12px;
			}
				.feedbackAvatar{
					width:50px;float:left;
				}
					.feedbackAvatar img{border:1px solid #e7e7e7;}
				.feedbackInfo{
					margin-left:10px;
					width:150px;
					float:left;
				}
					.feedbackAuthorName{color:#5f5f61;font-size:12px;font-weight:bold;margin-bottom:1px;}
					.feedbackAuthorInfo{font-size:11px;margin-bottom:5px;}
						.authorPosition{color:#72777a;}
						.authorCompany{color:#b4b4b4;text-decoration:underline;}
					.feedbacks .feedbackText{color:#000000;font-size:11px;margin-bottom:5px;text-align:justify;height:48px;}	
					.boxSolo .feedbackText{color:#000000;font-size:11px;margin-bottom:10px;text-align:justify;line-height:17px;max-height:280px;}
					
					.feedbacks .theSocialButtons{background:#f3f3f3;padding:6px 8px;border:1px solid #e4e4e4;position:absolute;bottom:18px;left:0px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}
							  .theSocialButtons .shareTail{background:url(images/share-arrow.png) no-repeat;width:11px;height:7px;position:absolute;bottom:-7px;left:3px;}
								
								a.share{padding-left:16px;background:url(images/ico-share.png) no-repeat left top;margin-left:4px;}
								a.share:hover{color:#88bae8;background-position:left bottom;}
								
					
					.feedbackOptions{font-size:11px;position:absolute;width:210px;bottom:0px}	
						.feedbackOptions .feedbackReadMore{float:left;width:40%;}
						.feedbackOptions .feedbackReadMore a{color:#919191;text-decoration:none;font-size:10px;}
						.feedbackOptions .feedbackReadMore a:hover{color:#AAA;}
						.feedbackOptions .feedbackDate{float:left;width:60%;color:#919191;font-size:10px;text-align:right;}
	
	.boxFooter:after,.feedbackOptions:after,.feedbackAuthorInfo:after,.feedbacks:after,.feedbackSocial:after,.feedbackAuthor:after,.theSocialButtons:after,.feedbackAuthorLocation:after{content: ".";display: block;height: 0;clear: both;visibility: hidden;}		
				    .twitter-button{margin-top:0px;float:left;width:80px;}
					.facebook-button{float:left;width:80px;}				
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
    	<div class="boxTitle">
        	What some of our customers say
        </div>
        <div class="boxBorder"></div>
        <div class="boxSolo">
        	<div class="feedback">
                <div class="feedbackAvatar">
                    <img src="images/blank2.jpg" />
                </div>
                <div class="feedbackInfo">
                    <div class="feedbackAuthorName">Chris Davidson <span class="flag "></span></div>
                    <div class="feedbackAuthorInfo">
                        <span class="authorPosition">Front End Developer, </span> 
                        <span class="authorCompany">36Stories</span>
                    </div>
                    <div class="feedbackText">
                        <p>The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. The quick brown fox jumps over the lazy dog just so you know. </p>
                    </div>
                    <div class="feedbackOptions">
                        <div class="feedbackReadMore">
                            <a href="#" class="back">back</a>
                        </div>
                        <div class="feedbackDate">
                            13th Sept. 2011
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="feedContainer">
            <div id="slides" class="feedBoxes">
                <?php
					$ctr = 0;
					foreach($result as $r){
						if(($ctr % $units) == 0){
							echo '<div class="feedbacks">';
							$end = 1;
						}
						if($end == 2){
							$feedback_class = "feedback";
						}else{
							$feedback_class = "feedback";
						}
							//avatar
							$avatar = trim($r->avatar);
							if($avatar == ''){
								$avatar = "images/blank-avatar.png";
							}else{
								$avatar = "http://dev.gearfish.com/uploaded_cropped/48x48/".$avatar;
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
							$maxchars = 80;
							
							if(strlen(trim($r->text)) <= $maxchars){
								$text = $r->text . ' <br />';																
							}else{
								$text = substr($r->text,0,$maxchars) . '<span style="color:#88bae8;font-size:10px;"> (read full feedback)</span>';								
							}
							
							   echo '<input type="hidden" value="'.$r->text.'" id="'.$r->id.'" />';
							   echo '<div class="'.$feedback_class.'">
										<div class="feedbackAuthor">
											<div class="feedbackAvatar">
												<img src="'.$avatar.'" />
											</div>
											<div class="feedbackInfo">
												<div class="feedbackAuthorName">'.$name.' <span class="flag flag-'.strtolower($r->countrycode).'"></span></div>
												<div class="feedbackAuthorInfo">
													<span class="authorPosition">'.$r->position.' </span> 
													<span class="authorCompany">'.$r->company.'</span>
												</div>
												<div class="feedbackText">
													'.$text.'
												</div>
											</div>
										</div>
										<div class="feedbackOptions">
											<div class="feedbackReadMore">
												<a href="javascript:;" id="1" class="share">&nbsp;</a>
												&nbsp;
											</div>
											<div class="feedbackDate">
												'.$date.'
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
					}
					
					
				?>
                
                <!-- end of group -->
            </div>
        </div>
        <!-- end of feedboxes -->
        <div class="boxOptions">
        	<div class="sendFeedback">
            	<a href="#">Send Feedback</a>
            </div>
            <div class="viewAll">
            	<input type="button" class="viewAllBtn" value="" />
            </div>
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
        Powered by 36Stories
    </div>
</div>
</body>
</html>