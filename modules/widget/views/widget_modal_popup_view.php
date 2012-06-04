<?=HTML::style('css/widget_master/embedded_widget_master_template.css')?>
<?=HTML::script('js/widget/display/master.js')?>

<script type="text/javascript">
	$(document).ready(function(){

        var link = '<?=URL::to('single')?>';
		var $slide = $('#theSoloSlides').cycle({
            fx:     'fade', 
            speed:  '1000', 
            timeout:'5000',
            pause : 0,
            timeoutFn: addScroll
		});
		
		$('#theSlides').cycle({
            fx:      'scrollHorz', 
            speed:   '500', 
            timeout: '5000',
            pause : 1,
            prev : '#prev',
            next : '#next',
            before: S36Display.before_cycle, // this hides visible social buttons before a transition is made
            after: S36Display.show_overflow	 // this displays the overflow of a feedback div to display the like button's iframe
		});
		$('#theSlides').mousewheel(function(event,delta){
			if (delta > 0){$('#theSlides').cycle('prev');}
			else{$('#theSlides').cycle('next');}
			return false;
		});
		
		$('.theFeedbackText').click(function(){
            var indexid = $(this).parent().parent().parent().attr('index-id');
            $slide.cycle(parseInt(indexid));
		});
		
		$('.theSocialButtons').hide();
		$('.share').hide();
		
		/* show the share icon when hovering on the feedback block */
        S36Display.sharebutton_hover();
		/* load the facebook and twitter social buttons when the share icon is clicked */
        S36Display.show_sharebuttons(link);
	})
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=154673521284687";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="widget">
	<div id="widgetHeader">
    	<div class="grids">
            <div class="g2of3">
                <div class="theWidgetTitle">
                    <?=$flavor_text?>
                </div>
            </div>
            <div class="g1of3">
            <!--
                <div class="viewAllFeedbackButton align-right">
                    <input type="button" />
                </div>
            -->
            </div>
        </div>
    </div>
    <div class="widgetStyledBorder"></div>
    <div id="widgetBody">

        <div id="theSoloBox">
            <div id="theSoloSlides">
            <?if($result):?>
                <?php    

                    $ctr = 0;
                    $units = 3;
                    $max = $row_count; 
                    foreach($result as $r) {
                        //avatar
                        $pic = trim($r->avatar);
                        $avatar = null;
                        $no_avatar_class = null;
                        if ($r->rules->displayimg == 1)  {
                            if($pic == false){
                                $no_avatar_class = "no-avatar-class";
                            }else{
                                $avatar = '<img src="/uploaded_cropped/150x150/'.$pic.'" />';
                            }    
                        } else {
                            $avatar = '<img src="/img/blank-avatar.png" />';
                        }
                                
                        //country code for the class
                        $cc = '&nbsp;'; 	
                        if($r->rules->displaycountry == 1) {
                            $cc = strtolower($r->countrycode);        
                        }
                        
                        //date
                        $date = '&nbsp;'; 
                        if($r->rules->displaysbmtdate == 1)  { 
                            if(trim($r->date) != ""){
                                $date 	= date('F d, Y',strtotime($r->date));
                            }else{
                                $date	= '';
                            }
                        }  
                        
                        //check if name is available:
                        $name = '&nbsp;';
                        if ($r->rules->displayname == 1) {
                            if ($r->firstname != false) {
                               $name = '<span class="left">'.$r->firstname.' '.$r->lastname.'</span> &nbsp;&nbsp;<span class="flag flag-'.$cc.' left" style="margin-top:6px;"></span>'; 
                            } 
                        } 
                        
                        //check if position is available:  
                        $comp = '&nbsp;';								

                        $companyname = $r->companyname;
                        if($r->rules->displayurl == 1) {
                            $companyname = "<a href='".$r->url."' target='_blank'>".$r->companyname."</a>";    
                        }

                        if(($r->rules->displayposition == 1) && ($r->rules->displaycompany == 1)){								
                            $comp = $r->position.', <span class="highlight">'.$companyname.'</span>';
                        }
                        
                        if(($r->rules->displaycompany == 1) && ($r->rules->displayposition != 1)){								
                            $comp = $companyname;								
                        }
                        
                        if(($r->rules->displaycompany != 1) && ($r->rules->displayposition == 1)){								
                            $comp = $r->position;								
                        }                                            

                        $text = strip_tags($r->text);
                  
                        echo '<div class="soloFeedback">
                                <div class="soloFeedbackAvatar">
                                    '.$avatar .'
                                </div>
                                <div class="soloFeedbackDetails '.$no_avatar_class.'">
                                    <div class="soloFeedbackText">
                                        <p>"'.trim($text).'"</p>
                                    </div>
                                    <div class="soloFeedbackAuthor">
                                        <ul>
                                            <li class="soloFeedbackAuthorName">'.$name.' </li>
                                            <li class="soloFeedbackAuthorCompany">'.$comp.'</li>
                                            <li class="soloFeedbackDate">'.$date.'</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                    
                    }
                ?> 
            </div>
        </div>
        <div id="theLoopBox">
            <div id="theSlides">
				<?php 
                    foreach($result as $r){
                        if(($ctr % $units) == 0){
                            echo '<div class="theFeedbacks grids">';
                            $end = 1;
                        }
                        if($end == 1){
                            $feedback_class = "theFeedback left";
                        }elseif($end == 2){
                            $feedback_class = "theFeedback center";
                        }else{
                            $feedback_class = "theFeedback right";
                        }
                        
                        //avatar
                        $pic = trim($r->avatar);
                        if ($r->rules->displayimg == 1) {
                            if ($pic == '') {
                                $avatar = "/img/48x48-blank-avatar.jpg";
                            }else{
                                $avatar = "/uploaded_cropped/48x48/".$pic;
                            }
                        } else {
                            $avatar = "/img/48x48-blank-avatar.jpg";
                        }
                            
                        $cc = '&nbsp;';
                        if($r->rules->displaycountry == 1) {
                            $cc = strtolower($r->countrycode);        
                        }
                        
                        //date 
                        $date	= '&nbsp;';
                        if($r->rules->displaysbmtdate == 1)  { 
                            if($r->date != false){
                                $date 	= '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
                            }                        
                        }
                              
                        //check if name is available: 
                        $name = '&nbsp;'; 
                        if ($r->rules->displayname == 1) { 
                            if($r->firstname != false){  
                                $name = $r->firstname.' '.$r->lastname; 
                            }                        
                        }
                            		
                        $comp = '&nbsp;';								

                        $companyname = $r->companyname;
                        if($r->rules->displayurl == 1) {
                            $companyname = "<a href='".$r->url."' target='_blank'>".$r->companyname."</a>";    
                        }

                        if(($r->rules->displayposition == 1) && ($r->rules->displaycompany == 1)){								
                            $comp = $r->position.', '.$companyname;								
                        }
                        
                        if(($r->rules->displaycompany == 1) && ($r->rules->displayposition != 1)){								
                            $comp = $companyname;								
                        }
                        
                        if(($r->rules->displaycompany != 1) && ($r->rules->displayposition == 1)){								
                            $comp = $r->position;								
                        }                         

                        $loc = '&nbsp;';								
                        if($r->rules->displaycountry == 1) {
                            $loc = $r->countryname.', '.$r->city;								 
                        } 
                                                
                        $maxchars = 157;							
                        if(strlen(trim($text)) <= $maxchars){
                            $text = $text . ' <br />';																
                        }else{
                            $text = substr($text,0,$maxchars) . '<span style="color:#88bae8;font-size:10px;" feed-id="'.$r->id.'"> (read full feedback)</span>';								
                        }							
                           echo '<div class="g1of3" index-id="'.$ctr.'">
                                    <div class="'.$feedback_class.'" id="feedbackid-'.$r->id.'">
                                        <input type="hidden" class="theFullFeedbackText" data-flag="'.$cc.'" value="<p>'.$text.'</p>" />                        	
                                        <div class="block">
                                            <div class="theFeedbackAvatar">
                                                <img src="'.$avatar.'" />
                                                <div class="flag flag-'.$cc.' flag-fix"></div>
                                            </div>
                                            <div class="theFeedbackAuthorInfo">
                                                <div class="theFeedbackAuthorName large">'.$name.'</div>
                                                <div class="theFeedbackAuthorCompany normal">'.$comp.'</div>
                                                <div class="theFeedbackAuthorLocation small">'.$loc.'</div>
                                            </div>
                                        </div>
                                        <div class="block">
                                            <div class="theFeedbackText" feed-id="'.$r->id.'">
                                                '.$text.'
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
                                    </div>
                                </div>';
                    if(($end == $units) || $ctr == ($max - 1)){
                        echo '</div>';
                    }
                    $end++;
                    $ctr++;
                }
            ?>
            </div>
        </div> 
        <?else:?>
            <div style='margin:0 auto;text-align:center;padding-top:60px'><h2>Sorry, no feedback here yet.</h2></div>
        <?endif?>
    </div>
    <div id="widgetFooter">
    	<div class="block">
            <div class="thePagination">
                <?if($result):?>
                    <span id="pager">
                        <span id="prev">◄</span>
                        <span class="pagination"></span>
                        <span id="next">►</span>
                    </span>
                <?endif?>
            </div>
            <div class="theFooterText">
                <a href="#">Powered by 36Stories</a>
            </div>
        </div>
    </div>
</div>

<!--[if IE]>
<?=HTML::style('css/widget_master/ie_fix.css')?>
<![endif]-->
<?=$css?>
<?=$js?>
