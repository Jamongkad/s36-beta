<?=HTML::style('css/widget_master/embedded_widget_master_template.css')?>
<?=HTML::script('js/widget/display/master.js')?>

<script type="text/javascript">
	$(document).ready(function(){
		/* show the solo feedback when the feedbacktext class is clicked */
        var link = '<?=URL::to('single')?>';
	    S36Display.display_solofeedback(link);
		/* return to the loopbox when the back link is clicked */
		$('.back').click(function(){
			$('#theSoloBox').fadeOut('fast',function(){
				var element = $('.soloFeedbackText').jScrollPane(); 
				var api = element.data('jsp');
				api.destroy();
			});
			$('#theLoopBox').fadeIn('fast');
			$('.thePagination').fadeIn('fast');			
		});
		/* hide the following elements on document ready */
		$('#theSoloBox').hide();
		$('.theSocialButtons').hide();
		$('.share').hide();
		
		/* show the share icon when hovering on the feedback block */
        S36Display.sharebutton_hover();
		/* load the facebook and twitter social buttons when the share icon is clicked */
        S36Display.show_sharebuttons(link);
		/* add the slide effect on the element */
		var slides = $('#theSlides');
		slides.cycle({
				fx:      'scrollVert', 
				speed:   '500', 
				timeout: '5000',
				pause : 1,
				prev : '#prev',
				next : '#next',
				before: S36Display.before_cycle,//this hides visible social buttons before a transition is made
				after: S36Display.show_overflow//this displays the overflow of a feedback div to display the like button's iframe
		});
		/* apply a mousewheel scroll event on the slides */
		slides.mousewheel(function(event, delta){
			if (delta > 0){$(this).cycle('prev');}
			else{$(this).cycle('next');}
			return false;
		});
	});

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div id="fb-root"></div>
<div id="widget">
	<div id="widgetHeader">
    	<div class="theWidgetTitle">
        	<?=$flavor_text?>
        </div>
    </div>
    <div class="block">
    	<div class="widgetStyledBorder"></div>
    </div>
    <div id="widgetBody" class="block">
    	<div id="theLoopBox">
        	<div id="theSlides">
            	<?php
					$ctr = 0;
                    $units = 3;
                    $max = $row_count;
				    if($result) { 
                        foreach($result as $r){						

                            if(($ctr % $units) == 0){
                                echo '<div class="theFeedbacks grids">';
                                $end = 1;
                            }
                            if($end == 1){
                                $feedback_class = "theFeedback";
                            }elseif($end == 2){
                                $feedback_class = "theFeedback";
                            }else{
                                $feedback_class = "theFeedback";
                            }
                                
                            //avatar

                            $pic = trim($r->avatar);
                            if ($r->rules->displayimg == 1) {
                                if ($pic == false) {
                                    $avatar = "/img/48x48-blank-avatar.jpg";
                                }else{
                                    $avatar = "/uploaded_cropped/48x48/".$pic;
                                }
                            } else {
                                $avatar = "/img/48x48-blank-avatar.jpg";
                            }

                            //country code for the class
                            $cc = '&nbsp;'; 	
                            if($r->rules->displaycountry == 1) {
                                if($r->countrycode) {
                                    $cc = strtolower($r->countrycode);             
                                } 
                            }
                                
                            //date 
                            $date = '&nbsp;';
                            if($r->rules->displaysbmtdate == 1)  { 
                                if(trim($r->date) != ""){
                                    $date 	= '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
                                }                        
                            }
                                
                            //check if name is available: 
                            $name = '&nbsp;';
                            if ($r->rules->displayname == 1) { 
                                if((trim($r->firstname) != "")){  
                                    $name = $r->firstname.' '.$r->lastname; 
                                }                        
                            }
        
                            $comp = '&nbsp;';								

                            $companyname = ucwords($r->companyname);
                            if($r->rules->displayurl == 1) {
                                $companyname = "<a href='".$r->url."' target='_blank'>".ucwords($r->companyname)."</a>";    
                            }

                            if(($r->rules->displayposition == 1) && ($r->rules->displaycompany == 1)){
                                if($r->position && $r->companyname) {
                                    $comp = ucwords($r->position).', '.$companyname;								     
                                } 
                            }
                            
                            if(($r->rules->displaycompany == 1) && ($r->rules->displayposition != 1)){
                                $comp = $companyname;								
                            }

                            if(($r->rules->displaycompany != 1) && ($r->rules->displayposition == 1)){							
                                if($r->position) {
                                    $comp = ucwords($r->position);
                                } 
                            }								

                            $maxchars = 50;							
                            $text = strip_tags($r->text);
                            if(strlen(trim($text)) <= $maxchars){
                                $text = $text; 
                            }else{
                                $text = substr($text,0,$maxchars) . '<span style="color:#88bae8;font-size:10px;" feed-id="'.$r->id.'"> (read full feedback)</span>';								
                            }							

                            $hidden_text = htmlspecialchars($r->text);
                            echo '<div class="'.$feedback_class.'" id="feedbackid-'.$r->id.'">                    
                                  <input type="hidden" class="theFullFeedbackText" data-flag="'.$cc.'" value="'.$hidden_text.'"/>                        	
                                    <div class="block">	
                                        <div class="theFeedbackAvatar">
                                            <img src="'.$avatar.'" />
                                            <div class="flag flag-'.$cc.' flag-fix"></div>
                                        </div>
                                        <div class="theFeedbackAuthorInfo">
                                            <div class="theFeedbackAuthorName large">'.$name.'</div>
                                            <div class="theFeedbackAuthorCompany normal">'.$comp.'</div>
                                            <div class="block">
                                                <div class="theFeedbackText" feed-id="'.$r->id.'">
                                                    '.$text.'
                                                </div>
                                            </div>
                                        </div>                       
                                    </div>
                                    <div class="block">
                                        <div class="theFeedbackShare">
                                            <div class="grids">
                                                <div class="g1of3">
                                                    <div class="theShareIcon"><a href="javascript:;" feed-id="'.$r->id.'" class="share" style="display: inline; "></a>&nbsp;</div>
                                                </div>
                                                <div class="g2of3">
                                                    <div class="theFeedbackDate small align-right">'.$date.'</div>
                                                </div>
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
                        }
                    } else { 
                        echo "<div style='margin:0 auto;text-align:center;padding-top:60px'>
                                  <h2>Sorry, no feedback here yet.</h2>
                              </div>";
                    }
				?>
            </div>
        </div>
         
        <div id="theSoloBox">
        	<div id="theSoloSlides">
            	<div class="soloFeedback block">
                	<div class="soloFeedbackAvatar">                        
                        <img src="/img/48x48-blank-avatar.jpg" style="margin-bottom:15px"/>
                        <span class="back"><a href="javascript:;">back</a> </span>
                    </div>
                    <div class="soloFeedbackDetails">
                    	<div class="soloFeedbackAuthor">
                        	<ul>
                            	<li class="soloFeedbackAuthorName large"></li>
                                <li class="soloFeedbackAuthorCompany normal"></li>
                            </ul>
                        </div>
                       
                        <div class="soloFeedbackText"></div>                        

                        <div class="soloFeedbackSocialButtons block">                        	
                            <div class="twitter-button"></div> 
                            <div class="facebook-button"></div>                                                        
                        </div>                                               

                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <div class="theWidgetButtons block">
    	<div class="g1of2">
            &nbsp;
        </div>
        <div class="g1of2">
        	<div class="viewAllFeedbackButton align-right">
            <!--
	            <input type="button" class="viewAllBtn" value="">
            -->
            </div>
        </div>
    </div>
    <div class="thePagination block">
        <?if($result):?>
            <span id="pager">
                <span id="prev">◄</span>
                <span class="pagination"></span>
                <span id="next">►</span>
            </span>
        <?endif?>
    </div>
    <div id="widgetFooter" class="block">
        <div class="theFooterText">
        	<a href="#">Powered by 36Stories</a>
        </div>
    </div>
</div>
<!--[if IE]>
<?=HTML::style('css/widget_master/ie_fix.css')?>
<![endif]-->

<?=$css?>
