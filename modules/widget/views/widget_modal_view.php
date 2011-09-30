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
        div {
            position:relative;
            display:block;
        }
        body {
            margin:0;
            padding:0;
            width:100%;
            height:100%;
            font-family:Arial, Helvetica, sans-serif;
            font-size:12px;
            color:#555;
        }
        #popup {
            width:710px;
            height:370px;
            padding:15px 20px;
        } /* orig size is 750 x 400 pixels */
        #popup .popup-header {
            margin:0px 0px;
            padding:0px 20px 15px;
            border-bottom:1px solid #e0e0e0;
            font-size:16px;
            font-weight:bold;
        }
        #popup p {
            padding-top:0px;
            margin-top:0px;
        }
        #popup .popup-fullview {
            padding:20px;
            border-bottom:1px solid #e0e0e0;
        }
        #popup .popup-thumbs {
            padding:20px;
        }
        #popup .full-avatar {
            width:150px;
            height:150px;
            margin-right:20px;
            float:left;
        }
        #popup .slides:after, .feedback-name:after, .v-feedback:after, .name:after, .h-feedback:after, .feedback-block:after {
            content: ".";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
        }
        #popup .full-feedback-info {
            margin-top:10px;
        }
        #popup .full-feedback {
            width:500px;
            float:left;
        }
        #popup .full-feedback-2 {
            width:690px;
            float:left;
        }
        #popup .full-feedback-text {
            max-height:100px;
            line-height:20px;
            font-size:14px;
        }
        .feedback-name .name {
            float:left;
            font-size:20px;
            font-weight:bold;
            color:#000;
        }
        .popup-feedbacks{display:block;width:100%;}
        .feedback-position {
            font-size:14px;
            font-weight:bold;
            color:#252323;
        }
        .feedback-name .flag {
            margin-top:7px;
        }
        .feedback-date {
            margin-top:3px;
        }

        .pagination{text-align:center;font-size:10px;padding-top:10px;}
        .pagination a{text-decoration:none;padding:2px 1px;color:#b4b4b4;}
        .pagination a.activeSlide{color:#72777a;}
            
        .popup-thumbs,.popup-feedbacks{
            display:block;	
        }
        .feedback-block{display:block;}
        .thumb-feedback{width:215px;float:left;margin-right:8px;cursor:pointer;}
        .thumb-avatar{width:48px;margin-right:10px;float:left;padding-top:3px;}
        .thumb-info{width:157px;float:left;}
        .thumb-info .name .innername{float:left;font-weight:bold;color:#000;}
        .thumb-info .name .flag{float:left;}
        .thumb-feedback .position{font-size:11px;font-weight:bold;}
        .thumb-feedback .date{font-size:10px;color:#9da4a8}
        .thumb-feedback .text{color:#72777a;}
        *:focus{outline:none !important;}	

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
          <div class="popup-header">What some of our customers say</div>
          <div class="popup-fullview">
            <div class="fullview-slides"> 
              <?php //start of full view slides                 
                        foreach($feedback->result as $r){
                            
                                //avatar
                                $avatar = trim($r->avatar);
                                $textclass = null;
                                if($feedback->block_display->displayimg == 1 || $r->displayimg) { 
                                    if($avatar == ''){ 
                                        $textclass = "full-feedback-2";
                                    }else{
                                        $avatar = '<div class="full-avatar"> <img src="/uploaded_cropped/150x150/'.$avatar.'" /> </div>';
                                        $textclass = "full-feedback";
                                    }
                                } else {
                                    $avatar = null;     
                                }
                                
                                //country code for the class
                                $cc = strtolower($r->countrycode);
                                //date
                                $data = null;
                                if($feedback->block_display->displaysbmtdate == 1 || $r->displaysbmtdate == 1){
                                    $date = '<div class="feedback-date">'.date('F d, Y',strtotime($r->date)).'</div>';
                                }                                
                                //check if name is available:
                                $name = null;
                                if($feedback->block_display->displayname == 1 || $r->displayname == 1) {
                                    $name = $r->firstname.' '.$r->lastname;
                                }

                                $flag = null;
                                if($feedback->block_display->displaycountry == 1 || $r->displaycountry == 1) {
                                    $flag = $cc;
                                }

                                $name_string = '<div class="feedback-name">
                                                    <div class="name">'.$name.'</div>
                                                    <div class="flag flag-'.$flag.'"></div>
                                               </div>';
                                
                                //check if position is available:
                                $position = null; 
                                if($feedback->block_display->displayposition == 1 || $r->displayposition == 1) {
                                    $position = $r->position.", ";
                                }
                                
                                $company_name = null; 
                                if($feedback->block_display->displaycompany == 1 || $r->displaycompany == 1) {
                                    $company_name = $r->companyname;
                                }

                                $comp = '<div class="feedback-position">'.$position.$company_name.'</div>';
                                 
                                    $text = $r->text; 
                                    echo '<div class="slides">
                                            '.$avatar.'
                                            <div class="'.$textclass.'">
                                              <div class="full-feedback-text"><p>"'.trim($text).'"</p></div>
                                              <div class="full-feedback-info">
                                                <div class="feedback-name">
                                                  '.$name_string.'
                                                </div>
                                                  '.$comp.'
                                                  '.$date.'
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
                        $avatar = trim($r->avatar);
                        if($feedback->block_display->displayimg == 1 || $r->displayimg) { 
                            if($avatar == ''){
                                $avatar = "/img/48x48-blank-avatar.jpg";
                            }else{
                                $avatar = "/uploaded_cropped/48x48/".$avatar;
                            }
                        } else {
                            $avatar = null;     
                        }

                        //country code for the class
                        $cc = strtolower($r->countrycode);

                        //date
                        $date = null;
                        if($feedback->block_display->displaysbmtdate == 1 || $r->displaysbmtdate == 1){
                            $date = '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
                        }  
                        
                        //name string
                        $name = null;
                        if($feedback->block_display->displayname == 1 || $r->displayname == 1) {
                            $name = "<div class='innername'>".$r->firstname.' '.$r->lastname."</div>";
                        }

                        $flag = null;
                        if($feedback->block_display->displaycountry == 1 || $r->displaycountry == 1) {
                            $flag = "<div class='flag flag-$cc'></div>";
                        }

                        $name_string = "<div class='name'>".$name.$flag."</div>";
                        
                        //check if position is available:
                        $position = null; 
                        if($feedback->block_display->displayposition == 1 || $r->displayposition == 1) {
                            $position = $r->position.", ";
                        }
                        
                        $company_name = null; 
                        if($feedback->block_display->displaycompany == 1 || $r->displaycompany == 1) {
                            $company_name = $r->companyname;
                        }
                        
                            
                        $comp = '<div class="position">'.$position.$company_name.'</div>'; 
                        
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
                                        <img src="'.$avatar.'" />	
                                    </div>
                                    <div class="thumb-info">
                                        '.$name_string.'
                                        '.$comp.'
                                        '.$date.'
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
