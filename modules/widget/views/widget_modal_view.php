<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <?=HTML::style('css/grid.css')?>
        <?=HTML::style('css/flags.css')?>
        <?=HTML::script('js/jquery-1.6.2.min.js')?>
        <?=HTML::script('js/jquery.cycle.all.min.js')?>
        <?=HTML::script('js/jquery.mousewheel.min.js')?>
        <?=HTML::script('js/jquery.scroll.js')?>

        <script type="text/javascript">
            
            $(document).ready(function(){
                                            
                var $slide = $('.fullview-slides').cycle({
                    fx:     'fade', 
                    speed:  '1000', 
                    timeout:'1000',
                    pause : 0,
                    timeoutFn: addScroll
                });

                $('.popup-feedbacks').cycle({
                    fx:     '<?php echo $transition ?>', 
                    speed:  '<?php echo $speed ?>', 
                    timeout:'<?php echo $timeout ?>',
                    pause : 1,
                    pager: 	'.pagination'
                });
                  
                $('.fullview-slides').mousewheel(function(event,delta){
                    if (delta > 0){$('.fullview-slides').cycle('prev');}
                    else{$('.fullview-slides').cycle('next');}
                    return false;
                });
                
                $('.popup-feedbacks').mousewheel(function(event,delta){
                    if (delta > 0){$('.popup-feedbacks').cycle('prev');}
                    else{$('.popup-feedbacks').cycle('next');}
                    return false;
                });
                
                
                $('.thumb-feedback').click(function(){
                    var slideno = $(this).attr('id');
                    slideno = parseInt(slideno);
                    $slide.cycle(slideno);
                });
                
            });
            
            function addScroll(curr, next, opts, fwd){
                $(curr).find('.full-feedback-text').jScrollPane();	
            }
            
        </script>
    </head>
    <style type="text/css">
  
        <?=$themeCSS?>
        .jspContainer
        {
            overflow: hidden;
            position: relative;
        }

        .jspPane
        {
            position: absolute;
        }

        .jspVerticalBar
        {
            position: absolute;
            top: 0;
            right: 0;
            width: 15px;
            height: 100%;
            background:url(/img/scrollTrack.png) center repeat-y;
        }

        .jspHorizontalBar
        {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 16px;
        }

        .jspVerticalBar *,
        .jspHorizontalBar *
        {
            margin: 0;
            padding: 0;
        }

        .jspCap
        {
            display: none;
        }

        .jspHorizontalBar .jspCap
        {
            float: left;
        }

        .jspTrack
        {
            
            position: relative;
        }

        .jspDrag
        {
            background:url(/img/scrollDrag-bg.png) repeat;
            position: relative;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .jspHorizontalBar .jspTrack,
        .jspHorizontalBar .jspDrag
        {
            float: left;
            height: 100%;
        }

        .jspArrow
        {
            background: #50506d;
            text-indent: -20000px;
            display: block;
            cursor: pointer;
        }

        .jspArrow.jspDisabled
        {
            cursor: default;
            background: #80808d;
        }

        .jspVerticalBar .jspArrow
        {
            height: 16px;
        }

        .jspHorizontalBar .jspArrow
        {
            width: 16px;
            float: left;
            height: 100%;
        }

        .jspVerticalBar .jspArrow:focus
        {
            outline: none;
        }

        .jspCorner
        {
            background: #eeeef4;
            float: left;
            height: 100%;
        }

        /* Yuk! CSS Hack for IE6 3 pixel bug :( */
        * html .jspCorner
        {
            margin: 0 -3px 0 0;
        }    
    </style>
    <body>

        <div id="popup">
          <div class="popup-header">What some of our customers have to say</div>
          <div class="popup-fullview">
            <div class="fullview-slides"> 
              <?php //start of full view slides                 
                foreach($feedback->result as $r){
                    
                        //avatar
                        $avatar_pic = null;
                        $pic = trim($r->avatar); 
                        $avatar = null; 
                        $textclass = null;
                        if($r->displayimg == 1) { 
                            if($pic == ''){ 
                                $textclass = "full-feedback-2";
                            }else{
                                $avatar = '<div class="full-avatar"> <img src="/uploaded_cropped/150x150/'.$pic.'" /> </div>';
                                $textclass = "full-feedback";
                            }
                        }                                 

                        if($r->indlock == 0 && ($feedback->block_display->displayimg != 1 || $feedback->block_display->displayimg == 1)) {
                            $avatar_pic = $avatar;    
                        }


                        if($r->indlock == 1 && $feedback->block_display->displayimg == 1) {
                            $avatar_pic = $avatar;
                        }                     

                        //country code for the class
                        $cc = strtolower($r->countrycode);

                        //date
                        $date_string = null;

                        $date = null; 
                        if($r->displaysbmtdate == 1){
                            $date = '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
                        }  
                        
                        if($r->indlock == 0 && ($feedback->block_display->displaysbmtdate != 1 || $feedback->block_display->displaysbmtdate == 1)) {
                            $date_string = $date;    
                        }

                        if($r->indlock == 1 && $feedback->block_display->displaysbmtdate == 1) {
                            $date_string = '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
                        }                     

                        //check if name is available:
                        $name_string = null;

                        $name = null;
                        if($r->displayname == 1) {
                            $name = $r->firstname.' '.$r->lastname;
                        }

                        $flag = null;
                        if($r->displaycountry == 1) {
                            $flag = $cc;
                        }


                        if($r->indlock == 0 || $feedback->block_display->displayname != 1) {
                            $name_string = '<div class="feedback-name">
                                                <div class="name">'.$name.'</div>
                                                <div class="flag flag-'.$flag.'"></div>
                                           </div>';
                        }  

                        if($r->indlock == 1 && ($feedback->block_display->displayname == 1 && $feedback->block_display->displaycountry == 1)) {
                            $name_string = '<div class="feedback-name">
                                                <div class="name">'.$r->firstname.' '.$r->lastname.'</div>
                                                <div class="flag flag-'.$cc.'"></div>
                                           </div>';
                        }

                        if($r->indlock == 1 && ($feedback->block_display->displayname == 1 && $feedback->block_display->displaycountry != 1)) {
                            $name_string = '<div class="feedback-name">
                                                <div class="name">'.$r->firstname.' '.$r->lastname.'</div>
                                           </div>';
                        }
                        
                        if($r->indlock == 1 && ($feedback->block_display->displayname != 1 && $feedback->block_display->displaycountry == 1)) {
                            $name_string = '<div class="feedback-name">
                                                <div class="flag flag-'.$cc.'"></div>
                                           </div>';
                        }

                        if($r->indlock == 1 && ($feedback->block_display->displayname != 1 && $feedback->block_display->displaycountry != 1)) {
                            $name_string = '<div class="feedback-name"></div>';
                        }

                         //check if position is available:
                        /*
                        $position = null; 
                        if($feedback->block_display->displayposition == 1 || $r->displayposition == 1) {
                            $position = $r->position.", ";
                        }
                        
                        $company_name = null; 
                        if($feedback->block_display->displaycompany == 1 || $r->displaycompany == 1) {
                            $company_name = $r->companyname;
                        }

                        $comp = '<div class="feedback-position">'.$position.$company_name.'</div>';
                        */
                        //check if position is available:
                        $position = null; 
                        if($r->displayposition == 1) {
                            $position = $r->position.", ";
                        }
                        
                        $company_name = null; 
                        if($r->displaycompany == 1) {
                            $company_name = $r->companyname;
                        }
                        
                        if($r->indlock == 0 || $feedback->block_display->displayposition != 1) {
                            $comp = '<div class="feedback-position">'.$position.$company_name.'</div>';                        
                        }

                        if($r->indlock == 1 && ($feedback->block_display->displayposition == 1 && $feedback->block_display->displaycompany ==1)) {
                            $comp = "<div class='feedback-position'>".$r->position.", ".$r->companyname."</div>";     
                        }
                        
                        if($r->indlock == 1 && ($feedback->block_display->displayposition != 1 && $feedback->block_display->displaycompany == 1)) {
                            $comp = "<div class='feedback-position'>".$r->companyname."</div>";     
                        }

                        if($r->indlock == 1 && ($feedback->block_display->displayposition == 1 && $feedback->block_display->displaycompany != 1)) {
                            $comp = "<div class='feedback-position'>".$r->position."</div>";     
                        }

                        if($r->indlock == 1 && ($feedback->block_display->displayposition != 1 && $feedback->block_display->displaycompany != 1)) {
                            $comp = "<div class='feedback-position'></div>";     
                        }
                         
                            $text = $r->text; 
                            echo '<div class="slides">
                                    '.$avatar_pic.'
                                    <div class="'.$textclass.'">
                                      <div class="full-feedback-text"><p>"'.trim($text).'"</p></div>
                                      <div class="full-feedback-info">
                                        <div class="feedback-name">
                                          '.$name_string.'
                                        </div>
                                          '.$comp.'
                                          '.$date_string.'
                                      </div>
                                    </div>
                                  </div>'; 
                }
                        
              ?>
            </div>
          </div>

          <div class="popup-thumbs">
            <div class="popup-feedbacks">
             <?php
             $max = $feedback->total_rows;
             $ctr = 0;
                foreach($feedback->result as $r){
                    if(($ctr % $units) == 0){
                        echo '<div class="feedback-block">';
                        $end = 1;
                    }	

                    //avatar
                    $avatar_pic = null;
                    $pic = trim($r->avatar); 
                    $avatar = null;
                    if($r->displayimg == 1) { 

                        if($pic == ''){
                            $avatar = "/img/48x48-blank-avatar.jpg";
                        }else{
                            $avatar = "/uploaded_cropped/48x48/".$pic;
                        }

                    } 

                    if($r->indlock == 0 && ($feedback->block_display->displayimg != 1 || $feedback->block_display->displayimg == 1)) {
                        $avatar_pic = $avatar;    
                    }

                    if($r->indlock == 1 && $feedback->block_display->displayimg == 1) {
                        if($pic == ''){
                            $avatar_pic = "/img/48x48-blank-avatar.jpg";
                        }else{
                            $avatar_pic = "/uploaded_cropped/48x48/".$pic;
                        }
                    }                     

                    //country code for the class
                    $cc = strtolower($r->countrycode);


                    //date
                    $date_string = null;

                    $date = null;
                    if($r->displaysbmtdate == 1){
                        $date = '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
                    }  
                    
                    if($r->indlock == 0 && ($feedback->block_display->displaysbmtdate != 1 || $feedback->block_display->displaysbmtdate == 1)) {
                        $date_string = $date;    
                    }

                    if($r->indlock == 1 && $feedback->block_display->displaysbmtdate == 1) {
                        $date_string = '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
                    }                     
                    //name string
                    $name_string = null;

                    $name = null;
                    if($r->displayname == 1) {
                        $name = "<div class='innername'>".$r->firstname.' '.$r->lastname."</div>";
                    }

                    $flag = null;
                    if($r->displaycountry == 1) {
                        $flag = "<div class='flag flag-$cc'></div>";
                    }

                    if($r->indlock == 0 || $feedback->block_display->displayname != 1) {
                        $name_string = "<div class='name'>".$name.$flag."</div>";     
                    }  
                     
                    if($r->indlock == 1 && ($feedback->block_display->displayname == 1 && $feedback->block_display->displaycountry == 1)) {
                        $name_string = "<div class='name'>"."<div class='innername'>".$r->firstname.' '.$r->lastname."</div>"."<div class='flag flag-$cc'></div>"."</div>";     
                    }

                    if($r->indlock == 1 && ($feedback->block_display->displayname == 1 && $feedback->block_display->displaycountry != 1)) {
                        $name_string = "<div class='name'>"."<div class='innername'>".$r->firstname.' '.$r->lastname."</div>"."</div>";     
                    }
                    
                    if($r->indlock == 1 && ($feedback->block_display->displayname != 1 && $feedback->block_display->displaycountry == 1)) {
                        $name_string = "<div class='name'>"."<div class='flag flag-$cc'></div>"."</div>";     
                    }

                    if($r->indlock == 1 && ($feedback->block_display->displayname != 1 && $feedback->block_display->displaycountry != 1)) {
                        $name_string = "<div class='name'></div>";     
                    }

                    //check if position is available:
                    $position = null; 
                    if($r->displayposition == 1) {
                        $position = $r->position.", ";
                    }
                    
                    $company_name = null; 
                    if($r->displaycompany == 1) {
                        $company_name = $r->companyname;
                    }
                    
                    if($r->indlock == 0 || $feedback->block_display->displayposition != 1) {
                        $comp = '<div class="position">'.$position.$company_name.'</div>';                        
                    }

                    if($r->indlock == 1 && ($feedback->block_display->displayposition == 1 && $feedback->block_display->displaycompany ==1)) {
                        $comp = "<div class='position'>".$r->position.", ".$r->companyname."</div>";     
                    }
                    
                    if($r->indlock == 1 && ($feedback->block_display->displayposition != 1 && $feedback->block_display->displaycompany == 1)) {
                        $comp = "<div class='position'>".$r->companyname."</div>";     
                    }

                    if($r->indlock == 1 && ($feedback->block_display->displayposition == 1 && $feedback->block_display->displaycompany != 1)) {
                        $comp = "<div class='position'>".$r->position."</div>";     
                    }

                    if($r->indlock == 1 && ($feedback->block_display->displayposition != 1 && $feedback->block_display->displaycompany != 1)) {
                        $comp = "<div class='position'></div>";     
                    }
     
                    //check if the feedback has 100 chars or more
                    $maxchars = 100;
                    if(strlen(trim($r->text)) <= $maxchars){
                        $text = $r->text;
                    }else{
                        $text = substr($r->text,0,$maxchars) . ' <a href="javascript:;" class="more" onclick="showFullText(\''.$r->id.'\')">more...</a>';
                        echo '<input type="hidden" value="'.$r->text.'" id="fb-'.$r->id.'" />';
                    }
                    
                        echo '<div class="thumb-feedback" id="'.$ctr.'">
                                <div class="thumb-avatar">
                                    <img src="'.$avatar_pic.'" />	
                                </div>
                                <div class="thumb-info">
                                    '.$name_string.'
                                    '.$comp.'
                                    '.$date_string.'
                                    <div class="text">"'.$text.'"</div>
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
            <div class="pagination"></div>
          </div>
        </div>
    </body>
</html>
