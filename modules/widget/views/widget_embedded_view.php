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
    <?=$themeCSS?>
</style>
<body>
<?php if($type == "vertical"): ?>
<div class="v">
	<div class="title">What some of our customers have to say</div>
    <div id="feedback-solo">
    </div>
    <div id="feedback-container">
        <div class="feedbacks">
            <?php
                //I'm sorry...
                $ctr = 0;
                $max = $feedback->total_rows;
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
                        echo '<div class="v-feedback grids">
                                <div class="v-avatar g1of5">
                                    <img src="'.$avatar_pic.'" />	
                                </div>
                                <div class="info g4of5">
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
<?endif?>

<?if($type == "horizontal"):?>
<div class="v">
	<div class="title">What some of our customers have to say</div>
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
                    
                        echo '<div class="h-feedback '.$feedback_grid.' grids">
                                <div class="v-avatar g1of5">
                                    <img src="'.$avatar_pic.'" />	
                                </div>
                                <div class="info g4of5">
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
<?endif?>
</body>
</html>
