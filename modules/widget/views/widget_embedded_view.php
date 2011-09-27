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

        <script type="text/javascript">
            
            $(document).ready(function(){
                $('.feedbacks').cycle({
                            fx:     '<?php echo $transition ?>', 
                            speed:  '<?php echo $speed ?>', 
                            timeout:'<?php echo $timeout ?>',
                            pause : 1,
                            pager: 	'.pagination' 
                        });
                
                $('.feedbacks').mousewheel(function(event,delta){
                    if (delta > 0){$('.feedbacks').cycle('prev');}
                    else{$('.feedbacks').cycle('next');}
                    return false;
                });
                
                $('#feedback-solo').hide();
            });
             
            function showFeedbacks(){
                $('#feedback-container').fadeIn('fast');
                $('#feedback-solo').empty().append(backlink).fadeOut('fast');
            }
            
            function showFullText(id){ 
                var src  = $('#fb-'+id);
                var backlink = ' <a href="javascript:;" onclick="showFeedbacks()">back</a>';
                var text = src.val() + backlink;
                var inner = $(src).next().html();
                
                $('#feedback-container').hide('fast');
                $('#feedback-solo').append(inner).fadeIn('fast');
                $('#feedback-solo').find('.text').html(text);      
            }
            
        </script>
    </head>

<style type="text/css">
	div{position:relative;display:block;}
	body{margin:0;padding:0;width:100%;height:100%;font-family:Arial, Helvetica, sans-serif;}
	.v{display:block;background:#FFF;padding:10px;}
	.title{font-size:16px;text-align:center;padding:10px 0px;}
	.feedback,.feedbacks{display:block}
	.feedback-block{
			display:block;width:100%;
			padding:0px 0px;
		}
	.h-feedback{padding:10px 0px;}
	.v-feedback{border-top:1px solid #e8e8e8;margin:0px 10px;padding:10px 0px;display:block}
	.v-avatar{margin:0px 0px;padding-top:5px;text-align:right;}
	.info{font-size:11px;color:#72777a;background:#FFF;}
	.v-feedback:after,
	.name:after,
	.h-feedback:after{ 
		 content: ".";  
		 display: block; 
		 height: 0; 
		 clear: both;
		 visibility: hidden; 
		}
	.name{display:block;font-size:12px;color:#000;font-weight:bold;padding:0px 0px 3px 10px;}
	.name .innername{float:left;}
	.position{display:block;font-size:10px;font-weight:bold;padding:0px 0px 2px 10px;}
	.date{color:#9da4a8;font-size:10px;padding:0px 0px 1px 10px;}	
	.text{font-size:11px;padding:0px 0px 1px 10px;overflow:hidden;word-wrap: break-word;}
	.text a.more{text-decoration:underline;color:#069;}
	.pagination{text-align:center;font-size:10px;padding-top:10px;}
	.pagination a{text-decoration:none;padding:2px 1px;color:#b4b4b4;}
	.pagination a.activeSlide{color:#72777a;}
	#feedback-container{position:absolute;width:100%;display:block;}
	#feedback-solo{display:block;font-size:11px;position:absolute;width:100%;}
	#feedback-solo .text{padding-right:30px;}
	#feedback-solo a{text-decoration:underline;color:#069;}

</style>
<body>
<?php if($type == "vertical"): ?>

<div class="v">
	<div class="title">What some of our customers say</div>
    <div id="feedback-solo">
    </div>
    <div id="feedback-container">
        <div class="feedbacks">
            <?php
                $ctr = 0;
                $max = $feedback->total_rows;
                foreach($feedback->result as $r){
                    if(($ctr % $units) == 0){
                        echo '<div class="feedback-block">';
                        $end = 1;
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
                            
                            $name = '<div class="name"><div class="innername">'.$r->firstname.' '.$r->lastname.'</div> <div class="flag flag-'.$cc.'"></div></div>';
                            
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
                            $text = $r->text;
                        }else{
                            $text = substr($r->text,0,$maxchars) . ' <a href="javascript:;" class="more" onclick="showFullText(\''.$r->id.'\')">more...</a>';
                            echo '<input type="hidden" value="'.$r->text.'" id="fb-'.$r->id.'" />';
                        }
                        
                            echo '<div class="v-feedback grids">
                                    <div class="v-avatar g1of5">
                                        <img src="'.$avatar.'" />	
                                    </div>
                                    <div class="info g4of5">
                                        '.$name.'
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
<?endif?>

<?if($type == "horizontal"):?>
<div class="v">
	<div class="title">What some of our customers say</div>
    <div id="feedback-solo">
    </div>
    <div id="feedback-container">
        <div class="feedbacks">
            <?php
                $ctr = 0;
                $max = $feedback->total_rows;
                foreach($feedback->result as $r){
                    if(($ctr % $units) == 0){
                        echo '<div class="feedback-block">';
                        $end = 1;
                    }	
                        //avatar
                        $avatar = trim($r->avatar);
                        if($avatar == ''){
                            $avatar = "/img/48x48-blank-avatar.jpg";
                        }else{
                            $avatar = "/uploaded_cropped/48x48/".$avatar;
                        }
                        //country code
                        $cc 	= strtolower($r->countrycode);
                        //date
                        if(trim($r->date) != ""){
                            $date 	= '<div class="date">'.date('F d, Y',strtotime($r->date)).'</div>';
                        }else{
                            $date	= '';
                        }
                        
                        //check if name is available:
                        if((trim($r->firstname) != "")){
                            
                            $name = '<div class="name"><div class="innername">'.$r->firstname.' '.$r->lastname.'</div> <div class="flag flag-'.$cc.'"></div></div>';
                            
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
                            $text = $r->text;
                        }else{
                            $text = substr($r->text,0,$maxchars) . ' <a href="javascript:;" class="more" onclick="showFullText(\''.$r->id.'\')">more...</a>';
                            echo '<input type="hidden" value="'.$r->text.'" id="fb-'.$r->id.'" />';
                        }
                        
                            echo '<div class="h-feedback '.$feedback_grid.' grids">
                                    <div class="v-avatar g1of5">
                                        <img src="'.$avatar.'" />	
                                    </div>
                                    <div class="info g4of5">
                                        '.$name.'
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

<?endif?>
</body>
</html>
