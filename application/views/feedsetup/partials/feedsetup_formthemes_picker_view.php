<div class="form-design-slide">
    <div class="form-design-prev">
    </div>
    <div class="form-designs grids"> 
    <?php
        $form_slides = '';
        $units = 5;
        $ctr = 0;
        $max = count($form_themes);
        
        foreach($form_themes  as $form_colors => $val){
            if(($ctr % $units) == 0){
                $form_slides .= '<div class="form-design-group grids">';
                $end = 1;
            }

                $color_name = 'form-'.$form_colors;
                $form_slides .= '<div class="form-design" id="'.$color_name.'">
                                    <img src="/img/tab-designs/'.$form_colors.'-form.png" height="60" />
                                    <span>'.$val.'</span>
                                    <div id="preview" class="preview button-gray">
                                        Preview
                                    </div>
                                </div>';
            
             if(($end == $units) || $ctr == ($max - 1)){
                $form_slides .= '</div>';
            }
            $end++;
            $ctr++;
        }
        echo $form_slides
    ?>
    </div> 
    <div class="form-design-next">
    </div>
</div>
