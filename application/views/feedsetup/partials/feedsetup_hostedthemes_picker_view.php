<?php 
    $under = new Underscore;
    $form_slides = '';
    $units = 5;
    $ctr = 0;
    $max = count($themes);
    
    foreach($themes as $value){
        if (($ctr % $units) == 0) {
            $form_slides .= '<div class="form-design-group grids">';
            $end = 1;
        }

        if($data_type) { 
            $color_name = $data_type.'-'.$under->first($value->default);     
        } else {
            $color_name = $under->first($value->default);     
        }
           
        $form_slides .= '<div class="form-design" id="'.$color_name.'">
                            <img src="/img/display-thumb.png "/>
                            <br/>
                            <span>'.$under->last($value->default).'</span>
                        </div>';
        
        if(($end == $units) || $ctr == ($max - 1)){
            $form_slides .= '</div>';
        }
        $end++;
        $ctr++;
    }
    echo $form_slides
?>
